<?php

namespace App\Console\Commands;

use App\Models\TutorImport;
use App\Services\TutorSpreadsheetImporter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessTutorImports extends Command
{
    protected $signature = 'tutors:process-imports';

    protected $description = 'Process pending tutor spreadsheets stored in Cloudflare R2';

    public function handle(TutorSpreadsheetImporter $importer)
    {
        $import = DB::transaction(function () {
            $pending = TutorImport::where('status', 'pending')
                ->orderBy('id')
                ->lockForUpdate()
                ->first();

            if ($pending) {
                $pending->status = 'processing';
                $pending->started_at = now();
                $pending->save();
            }

            return $pending;
        });

        if (!$import) {
            return Command::SUCCESS;
        }

        $temporaryBase = tempnam(sys_get_temp_dir(), 'tutor-import-');
        if ($temporaryBase === false) {
            $this->failImport($import, 'Unable to create a temporary file.');
            return Command::FAILURE;
        }

        $extension = strtolower(pathinfo($import->original_filename, PATHINFO_EXTENSION));
        $temporaryFile = $temporaryBase . ($extension ? '.' . $extension : '');
        if ($temporaryFile !== $temporaryBase && !rename($temporaryBase, $temporaryFile)) {
            unlink($temporaryBase);
            $this->failImport($import, 'Unable to prepare the temporary spreadsheet file.');
            return Command::FAILURE;
        }

        $remoteStream = null;
        $localStream = null;

        try {
            $remoteStream = Storage::disk('r2')->readStream($import->storage_path);
            if (!is_resource($remoteStream)) {
                throw new \RuntimeException('Unable to read the spreadsheet from Cloudflare R2.');
            }

            $localStream = fopen($temporaryFile, 'wb');
            if (!$localStream || stream_copy_to_stream($remoteStream, $localStream) === false) {
                throw new \RuntimeException('Unable to download the spreadsheet from Cloudflare R2.');
            }

            $stats = $importer->import($temporaryFile, $import->id);
            $import->fill($stats);
            $import->status = 'completed';
            $import->finished_at = now();
            $import->save();

            $this->info("Tutor import {$import->id} completed: {$stats['inserted']} inserted, {$stats['skipped']} skipped.");
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $this->failImport($import, $e->getMessage(), $e);
            return Command::FAILURE;
        } finally {
            if (is_resource($remoteStream)) {
                fclose($remoteStream);
            }
            if (is_resource($localStream)) {
                fclose($localStream);
            }
            if (file_exists($temporaryFile)) {
                unlink($temporaryFile);
            }
        }
    }

    private function failImport(TutorImport $import, $message, \Throwable $exception = null)
    {
        $import->status = 'failed';
        $import->error_message = substr($message, 0, 60000);
        $import->finished_at = now();
        $import->save();

        Log::error('Tutor spreadsheet import failed.', [
            'import_id' => $import->id,
            'exception' => $exception,
        ]);
        $this->error("Tutor import {$import->id} failed: {$message}");
    }
}
