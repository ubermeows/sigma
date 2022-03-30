<?php

namespace Tests\Unit\Actions;

use Tests\TestCase;
use App\Models\Clip;
use App\Enums\ClipStates;
use App\Actions\UpdateClipFromTwitch;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class UpdateClipFromTwitchTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function update_active_clip()
    {
        $clip = Clip::factory()->create();

        $this->freezeSecond();

        $updatedClip = app(UpdateClipFromTwitch::class)->execute($clip);

        $this->assertTrue($clip->is($updatedClip));

        $this->assertEquals([
            'title' => 'OUH Dans les couilles',
            'views' => 12,
            'state' => ClipStates::Active,
            'freshed_at' => now(),
        ], $updatedClip->only('title', 'views', 'state', 'freshed_at'));
    }
}
