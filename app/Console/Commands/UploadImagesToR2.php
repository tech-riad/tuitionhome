<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
  use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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

        $files = File::allFiles($path);

        foreach ($files as $file) {

            $relative = str_replace($path . DIRECTORY_SEPARATOR, '', $file->getPathname());

            Storage::disk('r2')->put(
                $relative,
                fopen($file->getRealPath(), 'r')
            );

            $this->info($relative);
        }

        $this->info('Upload Complete');
    }
}
