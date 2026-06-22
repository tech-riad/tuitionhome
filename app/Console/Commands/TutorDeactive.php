<?php

namespace App\Console\Commands;

use App\Mail\VerifyEmailOtp;
use App\Mail\ActiveDeactiveMail;
use App\Models\SmsBalance;
use Illuminate\Console\Command;
use App\Models\Tutor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TutorDeactive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tutor:deactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate tutors if there is a 6-month gap since their last login';

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
     * @return void
     */


    public function handle()
    {
        // Fetch the count of inactive tutors
        $inactiveTutorsCount = DB::table('tutors')
            ->where('is_active', 1)
            ->whereDate('login_at', '<=', now()->subMonths(8))
            ->count();

        $this->info("Total tutors matching criteria: {$inactiveTutorsCount}");

        if ($inactiveTutorsCount > 0) {
            DB::table('tutors')
                ->where('is_active', 1)
                ->whereDate('login_at', '<=', now()->subMonths(8))
                ->update([
                    'is_active' => 0,
                    'is_sms' => 0,
                    'inactive_date' => now(),
                ]);

            $this->info("Total tutors deactivated: {$inactiveTutorsCount}");
        } else {
            $this->info("No tutors matched the criteria.");
        }

        $this->info('Tutor deactivation process completed.');
    }



}
