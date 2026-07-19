<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
  use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
class UploadImagesToR2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:images-to-r2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */




public function handle()
{
    $path = storage_path('app/public');

    $this->info("Upload Started");

    $startTime = microtime(true);

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    $totalFiles = 0;
    $uploadedFiles = 0;
    $failedFiles = 0;
    $totalBytes = 0;
    $failedList = [];

    foreach ($iterator as $file) {

        if (!$file->isFile()) {
            continue;
        }

        $totalFiles++;

        $relative = str_replace(
            $path . DIRECTORY_SEPARATOR,
            '',
            $file->getPathname()
        );

        try {

            Storage::disk('r2')->put(
                $relative,
                fopen($file->getPathname(), 'r')
            );

            $uploadedFiles++;
            $totalBytes += $file->getSize();

            if ($uploadedFiles % 100 == 0) {

                $this->info(
                    "Uploaded : {$uploadedFiles} / {$totalFiles}"
                );
            }

        } catch (\Throwable $e) {

            $failedFiles++;

            $failedList[] =
                $relative . " => " . $e->getMessage();

            $this->error("Failed : {$relative}");
        }
    }

    $seconds = microtime(true) - $startTime;

    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $secs = floor($seconds % 60);

    $totalGB = round($totalBytes / 1024 / 1024 / 1024, 2);

    $report = "========================================\n";
    $report .= "Cloudflare R2 Upload Report\n";
    $report .= "========================================\n";
    $report .= "Completed At : " . date('Y-m-d H:i:s') . "\n\n";

    $report .= "Total Uploaded Files : {$uploadedFiles}\n";
    $report .= "Failed Files         : {$failedFiles}\n";
    $report .= "Total Size           : {$totalGB} GB\n";
    $report .= "Time Taken           : {$hours} Hour {$minutes} Minute {$secs} Second\n";

    $report .= "\n========================================\n";

    if ($failedFiles > 0) {

        $report .= "FAILED FILE LIST\n";
        $report .= "========================================\n";

        foreach ($failedList as $file) {
            $report .= $file . PHP_EOL;
        }
    }

    file_put_contents(
        storage_path('app/public/upload-report.txt'),
        $report
    );

    $this->newLine();
    $this->info("========================================");
    $this->info("Upload Completed Successfully");
    $this->info("Uploaded Files : {$uploadedFiles}");
    $this->info("Failed Files   : {$failedFiles}");
    $this->info("Total Size     : {$totalGB} GB");
    $this->info("Time Taken     : {$hours}h {$minutes}m {$secs}s");
    $this->info("Report Saved   : storage/app/public/upload-report.txt");
    $this->info("========================================");
}


}
