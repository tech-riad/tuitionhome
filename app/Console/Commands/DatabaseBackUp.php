<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
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
        $backupDir = storage_path('app/backup');

        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $date = Carbon::now()->format('Y-m-d_H-i-s');

        $sqlFile = $backupDir . "/database_{$date}.sql";
        $zipFile = $backupDir . "/database_{$date}.zip";

        /*
        |--------------------------------------------------------------------------
        | Mysqldump Path
        |--------------------------------------------------------------------------
        */

        if (PHP_OS_FAMILY === 'Windows') {

            $mysqldump = 'C:\xampp\mysql\bin\mysqldump.exe';

        } else {

            $mysqldump = trim(shell_exec('which mysqldump'));

            if (!$mysqldump) {
                $this->error("mysqldump not found.");
                return Command::FAILURE;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Dump Database
        |--------------------------------------------------------------------------
        */

        $command = sprintf(
            '"%s" --user=%s --password=%s --host=%s %s > "%s"',
            $mysqldump,
            escapeshellarg(env('DB_USERNAME')),
            escapeshellarg(env('DB_PASSWORD')),
            escapeshellarg(env('DB_HOST')),
            escapeshellarg(env('DB_DATABASE')),
            $sqlFile
        );

        exec($command, $output, $result);

        if ($result !== 0 || !file_exists($sqlFile)) {

            $this->error("Database Backup Failed");

            return Command::FAILURE;
        }

        /*
        |--------------------------------------------------------------------------
        | Zip
        |--------------------------------------------------------------------------
        */

        $zip = new ZipArchive();

        if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {

            $zip->addFile($sqlFile, basename($sqlFile));

            $zip->close();

        } else {

            $this->error("Zip Failed");

            return Command::FAILURE;
        }

        /*
        |--------------------------------------------------------------------------
        | Delete Old Backup From R2
        |--------------------------------------------------------------------------
        */

        foreach (Storage::disk('r2')->files('database-backup') as $file) {

            Storage::disk('r2')->delete($file);

        }

        /*
        |--------------------------------------------------------------------------
        | Upload New Backup
        |--------------------------------------------------------------------------
        */

        Storage::disk('r2')->put(
            "database-backup/" . basename($zipFile),
            fopen($zipFile, 'r')
        );

        /*
        |--------------------------------------------------------------------------
        | Delete Local Files
        |--------------------------------------------------------------------------
        */

        @unlink($sqlFile);
        @unlink($zipFile);

        $this->info("");
        $this->info("==============================");
        $this->info("Database Backup Success");
        $this->info("Uploaded : " . basename($zipFile));
        $this->info("R2 Folder : database-backup/");
        $this->info("==============================");

        return Command::SUCCESS;
    }



}
