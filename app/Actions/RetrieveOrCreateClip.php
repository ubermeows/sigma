<?php

namespace App\Actions;

use App\Models\Clip;
use App\Models\Game;
use App\Dtos\RawClip;
use App\Models\Creator;
use App\Services\StateService;

class RetrieveOrCreateClip
{
    public function __construct(
        protected StateService $stateService,
    ){}

    public function execute(RawClip $rawClip, Game $game, Creator $creator): Clip
    {
        $state = $this->stateService->define($rawClip);

        return Clip::firstOrCreate(
            [
                'tracking_id' => $rawClip->id,
            ],
            [
                'creator_id' => $creator->id,
                'game_id' => $game->id,
                'url' => $rawClip->url,
                'title' => $rawClip->title,
                'thumbnail_url' => $rawClip->thumbnailUrl,
                'duration' => $rawClip->duration,
                'views'=> $rawClip->viewCount,
                'state' => $state,
                'freshed_at' => $rawClip->createdAt,
                'published_at' => $rawClip->createdAt,
            ],
        );
    }
}
