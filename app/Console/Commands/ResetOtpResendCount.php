<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tutor;
use Carbon\Carbon;

class ResetOtpResendCount extends Command
{
    protected $signature = 'reset:otp_resend_count';
    protected $description = 'Reset OTP resend count for all users once a day';

    public function handle()
    {
        Tutor::where('last_otp_resend', '<', Carbon::now()->subDay())
            ->update(['otp_resend_count' => 0]);

        $this->info('OTP resend counts reset successfully.');
    }
}
