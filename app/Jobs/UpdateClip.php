<?php

namespace App\Jobs;

use App\Models\Clip;
use App\Dtos\RawClipId;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use App\Managers\Twitch\TwitchManager;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdateClip implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        protected Clip $clip,
    ){}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $rawClip = app(TwitchManager::class)->getClip(new RawClipId(
            value: $this->clip->raw_id,
        ));

        $this->clip->update([
            'title' => $rawClip->title,
            'views' => $rawClip->viewCount,
        ]);
    }
}
