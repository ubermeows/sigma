<?php

namespace Tests\Unit\Jobs;

use Tests\TestCase;
use App\Models\Clip;
use App\Dtos\RawClip;
use App\Jobs\StoreClip;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class StoreClipTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function handle()
    {
        $rawClip = new RawClip(
            id: 'VibrantElegantClipsdadPJSalt',
            url: 'http://',
            title: 'OUH Dans les couilles',
            thumbnail_url: 'http://',
            creator_id: '519157370',
            creator_name: 'Bill__g8',
            duration: 12,
            view_count: 100,
            created_at: '2022-03-28',
        );

        (new StoreClip($rawClip))->handle();

        $this->assertDatabaseCount('clips', 1);

        $this->assertDatabaseHas('clips', [
            'tracking_id' => 'VibrantElegantClipsdadPJSalt',
        ]);
    }

    /**
     * @test
     */
    public function handle_clip_already_save()
    {
        $clip = Clip::factory()->create();

        $rawClip = new RawClip(
            id: $clip->tracking_id,
        );

        (new StoreClip($rawClip))->handle();

        $this->assertDatabaseCount('clips', 1);

        $this->assertDatabaseHas('clips', [
            'tracking_id' => $clip->tracking_id,
        ]);
    }
}
