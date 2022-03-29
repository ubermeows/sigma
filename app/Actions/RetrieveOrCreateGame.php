<?php

namespace App\Actions;

use App\Models\Game;
use App\Dtos\RawClip;
use Illuminate\Support\Str;
use App\Managers\Twitch\TwitchManager;

class RetrieveOrCreateGame
{
    public function execute(RawClip $rawClip): Game
    {
        $game = $this->retrieveGame($rawClip);

        return $game ?? $this->createGame($rawClip);
    }

    protected function retrieveGame(RawClip $rawClip): ?Game
    {
       return Game::where('tracking_id', $rawClip->gameId)->first();
    }

    protected function createGame(RawClip $rawClip): Game
    {
        $rawGame = app(TwitchManager::class)->getGame($rawClip);

        return Game::create([
            'tracking_id' => $rawGame->id,
            'name' => $rawGame->name,
            'slug' => Str::slug($rawGame->name),
            'box_art_url' => $rawGame->boxArtUrl,
        ]);
    }
}
