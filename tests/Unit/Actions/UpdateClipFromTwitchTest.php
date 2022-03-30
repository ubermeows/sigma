<?php

namespace Tests\Unit\Actions;

use Mockery;
use Tests\TestCase;
use App\Models\Clip;
use App\Enums\ClipStates;
use App\Actions\UpdateClipFromTwitch;
use App\Managers\Twitch\TwitchManager;
use App\Exceptions\ResponseIsEmptyException;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class UpdateClipFromTwitchTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function update_active_clip()
    {
        $clip = Clip::factory()->freshLongTimeAgo()->create();

        $updatedClip = app(UpdateClipFromTwitch::class)->execute($clip);

        $this->assertTrue($clip->is($updatedClip));

        $this->assertEquals([
            'title' => 'OUH Dans les couilles',
            'views' => 12,
            'state' => ClipStates::Active,
            'freshed_at' => now(),
        ], $updatedClip->only('title', 'views', 'state', 'freshed_at'));
    }

    /**
     * @test
     */
    public function update_dead_clip()
    {
        $clip = Clip::factory()->freshLongTimeAgo()->create();

        $this->instance(
            TwitchManager::class,
            Mockery::mock(TwitchManager::class, function ($mock) {
                $mock
                ->shouldReceive('getClip')
                ->andThrow(ResponseIsEmptyException::class);
            })
        );

        $updatedClip = app(UpdateClipFromTwitch::class)->execute($clip);

        $this->assertTrue($clip->is($updatedClip));

        $this->assertEquals([
            'state' => ClipStates::Dead,
            'freshed_at' => now(),
        ], $updatedClip->only('state', 'freshed_at'));
    }

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->freezeSecond();
    }
}
