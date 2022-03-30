<?php

namespace App\Actions;

use App\Models\Clip;
use App\Dtos\RawClip;
use App\Dtos\TrackingId;
use App\Enums\ClipStates;
use App\Managers\Twitch\TwitchManager;

class UpdateClipFromTwitch
{
    public function execute(Clip $clip): Clip
    {
        $rawClip = $this->getRawClip($clip);

        $state = $this->defineState($rawClip);

        $clip->update([
            'title' => $rawClip->title,
            'state' => $state,
            'views' => $rawClip->viewCount,
            'freshed_at' => now(),
        ]);

        return $clip;
    }

    protected function getRawClip(Clip $clip): RawClip
    {
        return app(TwitchManager::class)->getClip(new TrackingId(
            value: $clip->tracking_id,
        ));
    }

    protected function defineState(RawClip $rawClip): ClipStates
    {
        return ClipStates::Active;
    }
}
