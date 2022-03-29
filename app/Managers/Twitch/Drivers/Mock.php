<?php

namespace App\Managers\Twitch\Drivers;

use App\Dtos\RawClip;
use App\Dtos\RawGame;
use App\Dtos\Interval;
use App\Dtos\BearerToken;
use Illuminate\Support\Collection;
use App\Managers\Twitch\Contracts\Driver;

class Mock implements Driver
{
    public function getBearerToken(): BearerToken
    {
        return new BearerToken(
            value: '123456789',
            expiresIn: 1000,
        );
    }

    public function getClips(Interval $interval): Collection
    {
        $items = [
            [
                'id' => 'VibrantElegantClipsdadPJSalt-xx9LNEBxXConq7El',
                'url' => 'https://clips.twitch.tv/VibrantElegantClipsdadPJSalt-xx9LNEBxXConq7El',
                'embed_url' => 'https://clips.twitch.tv/embed?clip=VibrantElegantClipsdadPJSalt-xx9LNEBxXConq7El',
                'broadcaster_id' => '50119422',
                'broadcaster_name' => 'LaMegaforgeLive',
                'creator_id' => '519157370',
                'creator_name' => 'Bill__g8',
                'video_id' => '1439439639',
                'game_id' => '508289',
                'language' => 'fr',
                'title' => 'OUH Dans les couilles',
                'view_count' => 12,
                'created_at' => '2022-03-28T19:21:57Z',
                'thumbnail_url' => 'https://clips-media-assets2.twitch.tv/45083375404-offset-4924-preview-480x272.jpg',
                'duration' => 26,
            ],
        ];

        return collect($items)
            ->map(fn($item) => new RawClip($item));
    }

    public function getGame(RawClip $rawClip): RawGame
    {
        return new RawGame([
            'id' => '27284',
            'name' => 'Retro',
            'box_art_url' => 'https://static-cdn.jtvnw.net/ttv-boxart/27284-{width}x{height}.jpg',
        ]);
    }
}
