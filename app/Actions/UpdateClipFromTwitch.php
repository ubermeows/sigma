<?php

namespace App\Actions;

use Exception;
use App\Models\Clip;
use App\Dtos\RawClip;
use App\Dtos\TrackingId;
use App\Enums\ClipStates;
use App\Services\StateService;
use App\Managers\Twitch\TwitchManager;

class UpdateClipFromTwitch
{
    public function __construct(
        protected StateService $stateService,
    ){}

    public function execute(Clip $clip): Clip
    {
        try {

            $rawClip = $this->getRawClip($clip);

            $state = $this->stateService->define($rawClip);

            $clip->update([
                'title' => $rawClip->title,
                'state' => $state,
                'views' => $rawClip->viewCount,
                'freshed_at' => now(),
            ]);

        } catch (Exception $e) {
            $this->markHasDead($clip);
        }

        return $clip;
    }

    protected function getRawClip(Clip $clip): RawClip
    {
        return app(TwitchManager::class)->getClip(new TrackingId(
            value: $clip->tracking_id,
        ));
    }

    protected function markHasDead(Clip $clip): Clip
    {
        $clip->update([
            'state' => ClipStates::Dead,
            'freshed_at' => now(),
        ]);

        return $clip;
    }
}
