<?php

namespace Tests\Api\Clips;

use Tests\TestCase;
use App\Models\Clip;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\Sequence;

class SearchClipsWithDatesRangeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function search()
    {
    	$clips = Clip::factory()
            ->state(new Sequence(
                ['published_at' => '2020-01-01'],
                ['published_at' => '2020-01-02 10:00:00'],
                ['published_at' => '2020-01-03 10:00:00'],
                ['published_at' => '2020-01-04'],
            ))
            ->count(4)
            ->create();

        $arguments = http_build_query([
            'after_date' => '2020-01-02',
            'before_date' => '2020-01-03 23:59:00',
        ]);

        $response = $this->get('api/clips/search?' . $arguments);

        $response->assertStatus(200);

        $response->assertJson([
            'data' => [
                [
                    'id' => 2,
                ],
                [
                    'id' => 3,
                ],
            ],
        ]);
    }
}
