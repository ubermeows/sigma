<?php

namespace Tests\Unit\Actions;

use Tests\TestCase;
use App\Models\Clip;
use App\Models\Game;
use App\Dtos\RawClip;
use App\Models\Creator;
use App\Enums\ClipStates;
use App\Actions\RetrieveOrCreateClip;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class RetrieveOrCreateClipTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function retrieve_clip()
    {
        $clip = Clip::factory()->create();

        $rawClip = new RawClip(
            id: $clip->tracking_id,
            url: null,
            title: 'title',
            thumbnail_url: null,
            duration: 12,
            view: null,
            published_at: null,
        );

        $retrievedClip = app(RetrieveOrCreateClip::class)->execute(
            $rawClip,
            $clip->game,
            $clip->creator,
        );

        $this->assertFalse($retrievedClip->wasRecentlyCreated);

        $this->assertTrue($clip->is($retrievedClip));
    }

    /**
     * @test
     */
    public function create_clip()
    {
        $creator = Creator::factory()->create();
        $game = Game::factory()->create();

        $rawClip = new RawClip(
            id: 'VibrantElegantClipsdadPJSalt',
            url: 'http://',
            title: 'OUH Dans les couilles',
            thumbnail_url: 'http://',
            duration: 12,
            view_count: 100,
            created_at: '2022-03-28',
        );

        $clip = app(RetrieveOrCreateClip::class)->execute(
            $rawClip,
            $game,
            $creator,
        );

        $this->assertTrue($clip->wasRecentlyCreated);

        $this->assertInstanceOf(Clip::class, $clip);
        
        $this->assertEquals('VibrantElegantClipsdadPJSalt', $clip->tracking_id);
    }

    /**
     * @test
     * @dataProvider createSuspiciousClipProvider 
     */
    public function create_suspicious_clip(string $title)
    {
        $creator = Creator::factory()->create();
        $game = Game::factory()->create();

        $rawClip = new RawClip(
            id: 'VibrantElegantClipsdadPJSalt',
            url: 'http://',
            title: $title,
            thumbnail_url: 'http://',
            duration: 30,
            view_count: 100,
            created_at: '2022-03-28',
        );

        $clip = app(RetrieveOrCreateClip::class)->execute(
            $rawClip,
            $game,
            $creator,
        );

        $this->assertEquals(ClipStates::Suspect, $clip->state);
    }

    protected function createSuspiciousClipProvider(): array
    {
        return [
            ['aa[bb]'],
            ['aa｢bb｣'],
        ];
    }
}
