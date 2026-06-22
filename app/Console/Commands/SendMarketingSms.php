<?php

namespace App\Console\Commands;

use App\Models\MarketeingSms;
use App\Models\SmsMarketing;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendMarketingSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:marketingSms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send one-time marketing SMS to targeted users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sms = SmsMarketing::where(function ($query) {
                $query->whereNull('send_now')
                      ->where('send_latter', '<=', now());
            })
            ->where('status', 0)
            ->where('campain_status', 'pending')
            ->first();

        if (!$sms || !isset($sms->query)) {
            $this->warn('No valid SMS marketing campaign found.');
            return;
        }

        $sms->status = 1;
        $sms->campain_status = 'accepted';
        $sms->sms_sended_date = now();

        if ($sms->recurring !== null) {
            $sms->recurring_date = now()->addDays($sms->recurring);
        }

        if ($sms->user_type === 'tutor' || $sms->user_type === 'parent') {
            $audience = DB::select($sms->query);

            $audienceArray = collect($audience)->map(function ($row) {
                return (array) $row;
            });

            $audienceIds = $audienceArray->pluck('id', 'phone')->filter();
            $sms->updated_audience = $audienceIds->count();
            $sms->save();

            if ($sms->user_type === 'tutor') {
                foreach ($audienceArray as $row) {
                    MarketeingSms::create([
                        'user_type'    => $sms->user_type,
                        'tutor_id'     => $row['id'],
                        'phone'        => isset($row['phone']) ? $row['phone'] : null,
                        'status'       => 0,
                        'marketing_id' => $sms->id,
                        'sms_body'     => $sms->sms_body,
                    ]);
                }
            } elseif ($sms->user_type === 'parent') {
                foreach ($audienceIds as $phone => $id) {
                    MarketeingSms::create([
                        'user_type'    => $sms->user_type,
                        'parent_id'    => $id,
                        'phone'        => $phone,
                        'status'       => 0,
                        'marketing_id' => $sms->id,
                        'sms_body'     => $sms->sms_body,
                    ]);
                }
            }

        } elseif ($sms->user_type === 'unit') {
            try {
                $numbers = json_decode($sms->query, true, 512, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                \Log::error("JSON decode failed for unit campaign ID: {$sms->id}");
                return;
            }

            if (!is_array($numbers)) {
                \Log::error("Decoded numbers are not array for unit campaign ID: {$sms->id}");
                return;
            }

            $cleanedNumbers = array_unique(array_map('trim', $numbers));
            $sms->updated_audience = count($cleanedNumbers);
            $sms->save();

            foreach ($cleanedNumbers as $number) {
                try {
                    MarketeingSms::create([
                        'user_type'    => $sms->user_type,
                        'marketing_id' => $sms->id,
                        'phone'        => $number,
                        'status'       => 0,
                        'sms_body'     => $sms->sms_body,
                    ]);
                } catch (\Exception $e) {
                    \Log::error("Failed to create SMS record for number: $number | " . $e->getMessage());
                }
            }
        }

        $this->info('Marketing SMS sent successfully!');
    }
}