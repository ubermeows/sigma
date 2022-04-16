<?php

namespace Tests\Api\Clips;

use Tests\TestCase;
use App\Models\Clip;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchClipsWithDatesRangeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function search()
    {
    	$clip = Clip::factory()->create();

        $arguments = http_build_query([
            'after_date' => '2020-01-01',
            'before_date' => '2020-01-01',
        ]);

        $response = $this->get('api/clips/search?' . $arguments);

        $response->assertStatus(200);
    }
}
