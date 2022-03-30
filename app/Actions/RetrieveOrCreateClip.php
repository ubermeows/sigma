<?php

namespace App\Actions;

use App\Models\Clip;
use App\Models\Game;
use App\Dtos\RawClip;
use App\Models\Creator;
use App\Enums\ClipStates;
use App\Services\JudgeService;

class RetrieveOrCreateClip
{
    public function __construct(
        protected JudgeService $judgeService,
    ){}

    public function execute(RawClip $rawClip, Game $game, Creator $creator): Clip
    {
        $state = $this->defineState($rawClip);

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

    protected function defineState(RawClip $rawClip): ClipStates
    {
        $isSuspicious = $this->judgeService->adjudicate(
            title: $rawClip->title,
            duration: $rawClip->duration,
        );

        return match ($isSuspicious) {
            true => ClipStates::Suspect,
            false => ClipStates::Active,
        };
    }
}
