<?php

namespace Tests\Unit\Managers;

use Tests\TestCase;
use App\Dtos\RawClip;
use App\Dtos\RawGame;
use App\Dtos\TrackingId;
use App\Dtos\BearerToken;
use App\Services\IntervalFactory;
use Illuminate\Support\Collection;
use App\Managers\Twitch\TwitchManager;
use App\Exceptions\ResponseIsEmptyException;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class TwitchManagerWithRawApiDriverTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @group tier_dependency
     */
    public function get_bearer_token()
    {
        $bearerToken = app(TwitchManager::class)
            ->driver('rawapi')
            ->getBearerToken();

        $this->assertInstanceOf(BearerToken::class, $bearerToken);
        $this->assertIsString($bearerToken->value);
        $this->assertIsInt($bearerToken->expiresIn);
    }

    /**
     * @test
     * @group tier_dependency
     */
    public function get_clips()
    {
        $interval = IntervalFactory::currentWeek();

        $clips = app(TwitchManager::class)
            ->driver('rawapi')
            ->getClips($interval);

        $this->assertInstanceOf(Collection::class, $clips);
        $this->assertInstanceOf(RawClip::class, $clips[0]);
    }

    /**
     * @test
     * @group tier_dependency
     */
    public function get_clip()
    {
        $clip = app(TwitchManager::class)
            ->driver('rawapi')
            ->getClip(new TrackingId(
                value: 'VibrantElegantClipsdadPJSalt-xx9LNEBxXConq7El',
            ));

        $this->assertInstanceOf(RawClip::class, $clip);
    }

    /**
     * @test
     * @group tier_dependency
     */
    public function get_unknow_clip()
    {
        $this->expectException(ResponseIsEmptyException::class);

        app(TwitchManager::class)
            ->driver('rawapi')
            ->getClip(new TrackingId(
                value: 'unknow_id',
            ));
    }

    /**
     * @test
     * @group tier_dependency
     */
    public function get_game()
    {
        $rawGame = app(TwitchManager::class)
            ->driver('rawapi')
            ->getGame(new RawClip(
                game_id: 27284,
            ));

        $this->assertInstanceOf(RawGame::class, $rawGame);
    }
}
