<?php

namespace Tests\Api\Clips;

use Tests\TestCase;
use App\Models\Clip;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchClipsWithRelationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function search()
    {
    	$clip = Clip::factory()->create();

        $response = $this->get('api/clips/search?relations=game,creator');

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                [
                    'game' => $clip->game->only(
                        'id', 
                        'tracking_id', 
                        'name', 
                        'slug', 
                        'box_art_url'
                    ),
                    'creator' => $clip->creator->only(
                        'id', 
                        'tracking_id', 
                        'name', 
                        'slug', 
                    ),
                ]
            ],
        ]);
    }
}
