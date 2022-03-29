<?php

namespace App\Actions;

use App\Models\Clip;
use App\Models\Game;
use App\Dtos\RawClip;
use App\Models\Creator;

class RetrieveOrCreateClip
{
    public function execute(RawClip $rawClip, Game $game, Creator $creator): Clip
    {
        return Clip::firstOrCreate(
            [
                'raw_id' => $rawClip->id,
            ],
            [
                'creator_id' => $creator->id,
                'game_id' => $game->id,
                'url' => $rawClip->url,
                'title' => $rawClip->title,
                'thumbnail_url' => $rawClip->thumbnailUrl,
                'duration' => $rawClip->duration,
                'views'=> $rawClip->viewCount,
                'published_at' => $rawClip->createdAt,
            ],
        );
    }
}
