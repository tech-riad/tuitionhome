<?php

namespace App\Console\Commands;

use App\Models\AllNotice;
use App\Models\PopupImage;
use App\Models\PopupImageData;
use App\Models\PopupNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendPopupImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:popup';

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

        $popupSend = PopupImage::where('status', 0)
                    ->whereDate('send_later_time', now()->toDateString())
                    ->get();
        foreach ($popupSend as $send) {
            $send->status = 1;
            $send->send_later_time = null;
            $send->send_now = 1;
            $send->save();
        }

        // dd($popupSend);

        $popup = PopupNotification::where(function ($query) {
                $query->where('send_now', '<=', now())
                      ->orWhere('send_latter', '<=', now());
            })
            ->where('status', 0)
            ->where(function ($query) {
                $query->where('campain_status', 'pending')
                      ->orWhere('campain_status', 'accepted');
            })
            ->first();


        if ($popup && isset($popup->query)) {
            $audience = DB::select($popup->query);
            $audienceIds = collect($audience)->pluck('id')->filter();
            $audienceCount = $audienceIds->count();

            $popup->updated_audience = $audienceCount;
            $popup->status = 1;
            $popup->campain_status = 'accepted';
            $popup->save();

            if($popup->user_type == 'tutor'){
                foreach ($audienceIds as $tutor) {
                    $exists = PopupImageData::where('tutor_id', $tutor)
                                       ->where('popupnotification_id', $popup->id)
                                       ->exists();

                    if (!$exists) {
                        PopupImageData::create([
                            'user_type'            => $popup->user_type,
                            'tutor_id'             => $tutor,
                            'status'               => 1,
                            'popupnotification_id' => $popup->id,
                            'placement_url'        => $popup->placement_url,
                            'navigate_link'        => $popup->navigate_link,
                            'image'                => $popup->image,
                            'created_at'           => now(),
                            'updated_at'           => now(),
                        ]);
                    }
                }

            }elseif($popup->user_type == 'parents'){
                foreach ($audienceIds as $parent) {
                    $exists = PopupImageData::where('parent_id', $parent)
                                       ->where('marketting_id', $popup->id)
                                       ->exists();

                    if (!$exists) {
                        PopupImageData::create([
                            'user_type'            => $popup->user_type,
                            'parent_id'            => $parent,
                            'status'               => 1,
                            'popupnotification_id' => $popup->id,
                            'placement_url'        => $popup->placement_url,
                            'navigate_link'        => $popup->navigate_link,
                            'image'                => $popup->image,
                            'created_at'           => now(),
                            'updated_at'           => now(),
                        ]);
                    }
                }

            }
            $this->info('Notices sent successfully!');
        } else {
            $this->warn('No valid popups found.');
        }
    }
}
