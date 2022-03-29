<?php

namespace Tests\Unit\Managers;

use Tests\TestCase;
use App\Dtos\RawClip;
use App\Dtos\RawGame;
use App\Dtos\BearerToken;
use App\Services\IntervalFactory;
use Illuminate\Support\Collection;
use App\Managers\Twitch\TwitchManager;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class TwitchManagerWithMockDriverTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function get_bearer_token()
    {
        $bearerToken = app(TwitchManager::class)
            ->driver('mock')
            ->getBearerToken();

        $this->assertInstanceOf(BearerToken::class, $bearerToken);
        $this->assertIsString('123456789');
        $this->assertIsInt(1000);
    }

    /**
     * @test
     */
    public function get_clips()
    {
        $interval = IntervalFactory::currentDay();

        $clips = app(TwitchManager::class)
            ->driver('mock')
            ->getClips($interval);

        $this->assertInstanceOf(Collection::class, $clips);
        $this->assertInstanceOf(RawClip::class, $clips[0]);

        $this->assertEquals([
            'id' => 'VibrantElegantClipsdadPJSalt-xx9LNEBxXConq7El',
            'url' => 'https://clips.twitch.tv/VibrantElegantClipsdadPJSalt-xx9LNEBxXConq7El',
            'creatorId' => '519157370',
            'creatorName' => 'Bill__g8',
            'gameId' => '508289',
            'title' => 'OUH Dans les couilles',
            'viewCount' => 12,
            'createdAt' => '2022-03-28T19:21:57Z',
            'thumbnailUrl' => 'https://clips-media-assets2.twitch.tv/45083375404-offset-4924-preview-480x272.jpg',
            'duration' => 26,
        ], $clips[0]->toArray());
    }

    /**
     * @test
     */
    public function get_game()
    {
        $rawGame = app(TwitchManager::class)
            ->driver('mock')
            ->getGame(new RawClip(
                game_id: 27284,
            ));

        $this->assertInstanceOf(RawGame::class, $rawGame);

        $this->assertEquals([
            'id' => '27284',
            'name' => 'Retro',
            'boxArtUrl' => 'https://static-cdn.jtvnw.net/ttv-boxart/27284-{width}x{height}.jpg',
        ], $rawGame->toArray());
    }
}
