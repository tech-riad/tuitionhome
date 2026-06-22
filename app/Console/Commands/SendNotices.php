<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Marketting;
use App\Models\AllNotice;

class SendNotices extends Command
{
    protected $signature = 'send:notices';
    protected $description = 'Send notices to tutors every five minutes';

    public function handle()
    {
        $notice = Marketting::where(function ($query) {
                $query->where('send_now', '<=', now())
                      ->orWhere('send_latter', '<=', now());
            })
            ->where('status', 0)
            ->where(function ($query) {
                $query->where('campain_status', 'pending')
                      ->orWhere('campain_status', 'accepted');
            })
            ->first();


        if ($notice && isset($notice->query)) {
            $audience = DB::select($notice->query);
            $audienceIds = collect($audience)->pluck('id')->filter();
            $audienceCount = $audienceIds->count();

            $notice->updated_audience = $audienceCount;
            $notice->status = 1;
            $notice->campain_status = 'accepted';
            $notice->save();

            if($notice->user_type == 'tutor'){
                foreach ($audienceIds as $tutor) {
                    $exists = AllNotice::where('tutor_id', $tutor)
                                       ->where('marketting_id', $notice->id)
                                       ->exists();

                    if (!$exists) {
                        AllNotice::create([
                            'user_type'    => $notice->user_type,
                            'tutor_id'     => $tutor,
                            'status'       => 1,
                            'marketting_id'=> $notice->id,
                            'title'        => $notice->title,
                            'description'  => $notice->description,
                        ]);
                    }
                }

            }elseif($notice->user_type == 'parents'){
                foreach ($audienceIds as $parent) {
                    $exists = AllNotice::where('parent_id', $parent)
                                       ->where('marketting_id', $notice->id)
                                       ->exists();

                    if (!$exists) {
                        AllNotice::create([
                            'user_type'    => $notice->user_type,
                            'parent_id'     => $parent,
                            'status'       => 1,
                            'marketting_id'=> $notice->id,
                            'title'        => $notice->title,
                            'description'  => $notice->description,
                        ]);
                    }
                }

            }
            $this->info('Notices sent successfully!');
        } else {
            $this->warn('No valid notices found.');
        }
    }



}
