<?php

namespace App\Console\Commands\DatabaseOptimization;

use App\Models\Tutor;
use App\Models\TutorLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class OldImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:optimize';

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
        $fields = ['ssc_c', 'ssc_m', 'hsc_c', 'hsc_m', 'nid', 'university_c', 'diploma_c', 'post_graduation_c', 'cv', 'others'];

        $tutors = Tutor::where('is_active', 0)
            ->where('login_at', '<', now()->subYear())
            ->get();

        foreach ($tutors as $tutor) {

            $certificate = $tutor->TutorCertificate;

            if (!$certificate) {
                continue;
            }

            foreach ($fields as $field) {
                $filePath = $certificate->$field;

                if (!$filePath) {
                    continue;
                }
                if ($filePath && Storage::exists("public/tutor-certificate/{$filePath}")) {
                    Storage::delete("public/tutor-certificate/{$filePath}");
                    $certificate->$field = null;
                }
            }

            $certificate->save();
            $logs = TutorLog::where('tutor_id', $tutor->id)->get();
            foreach ($logs as $log) {
                foreach ($fields as $field) {
                    if ($log->$field) {
                        $filePath = $log->$field;
                        if (Storage::disk('public')->exists("log-certificate-images/{$filePath}")) {
                            Storage::disk('public')->delete("log-certificate-images/{$filePath}");
                        }
                    }
                }

                $log->delete();
            }
        }
    }
}