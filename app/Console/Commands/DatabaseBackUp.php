<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class DatabaseBackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Database Backup';

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
         $backupDirectory = storage_path('app/backup');
         $filename = "backup-" . Carbon::now()->format('Y-m-d') . ".sql";
         $backupFilePath = $backupDirectory . "/" . $filename;

         // Ensure backup directory exists
         if (!is_dir($backupDirectory)) {
             mkdir($backupDirectory, 0755, true);
         }

         // Create the .sql backup file
         $command = "mysqldump --user=" . escapeshellarg(env('DB_USERNAME')) .
                    " --password=" . escapeshellarg(env('DB_PASSWORD')) .
                    " --host=" . escapeshellarg(env('DB_HOST')) .
                    " " . escapeshellarg(env('DB_DATABASE')) .
                    " > " . escapeshellarg($backupFilePath);
         $returnVar = null;
         $output = null;
         exec($command, $output, $returnVar);

         // Retain only the 3 most recent backups
         $backupFiles = glob($backupDirectory . '/backup-*.sql');
         if (count($backupFiles) > 3) {
             usort($backupFiles, function ($a, $b) {
                 return filemtime($a) - filemtime($b);
             });

             $filesToDelete = array_slice($backupFiles, 0, -3);
             foreach ($filesToDelete as $file) {
                 unlink($file);
             }
         }

         return $filename; // Return the filename of the newly created backup
     }


}