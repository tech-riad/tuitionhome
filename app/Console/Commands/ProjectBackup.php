<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class ProjectBackup extends Command
{
    protected $signature = 'project:backup';

    protected $description = 'Backup full project to Cloudflare R2';

    public function handle()
    {
        $start = microtime(true);

        $projectPath = base_path();

        $backupDir = storage_path('app/project-backup');

        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $fileName = 'project-' . Carbon::now()->format('Y-m-d_H-i-s') . '.zip';

        $zipPath = $backupDir . '/' . $fileName;

        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {

            $this->error("Unable to create zip.");

            return Command::FAILURE;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($projectPath, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        $count = 0;

        foreach ($iterator as $file) {

            if (!$file->isFile()) {
                continue;
            }

            $relative = str_replace($projectPath . DIRECTORY_SEPARATOR, '', $file->getPathname());

            // Skip folders/files
            if (
                str_starts_with($relative, 'vendor/') ||
                str_starts_with($relative, '.git/') ||
                str_starts_with($relative, 'node_modules/') ||
                str_contains($relative, 'storage/logs/') ||
                basename($relative) == 'error_log'
            ) {
                continue;
            }

            $zip->addFile($file->getPathname(), $relative);

            $count++;
        }

        $zip->close();

        // Delete previous backup from R2
        foreach (Storage::disk('r2')->files('project-backup') as $old) {

            Storage::disk('r2')->delete($old);

        }

        // Upload
        Storage::disk('r2')->put(
            'project-backup/' . $fileName,
            fopen($zipPath, 'r')
        );

        $size = round(filesize($zipPath) / 1024 / 1024, 2);

        unlink($zipPath);

        $seconds = round(microtime(true) - $start);

        $this->info("");
        $this->info("=======================================");
        $this->info("Project Backup Success");
        $this->info("Files      : {$count}");
        $this->info("Zip Size   : {$size} MB");
        $this->info("Time       : {$seconds} sec");
        $this->info("Uploaded   : project-backup/{$fileName}");
        $this->info("=======================================");

        return Command::SUCCESS;
    }
}
