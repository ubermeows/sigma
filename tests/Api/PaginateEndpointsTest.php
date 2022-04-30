<?php

namespace Tests\Api\Clips;

use Tests\TestCase;
use App\Models\Clip;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaginateEndpointsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @dataProvider paginateProvider
     */
    public function paginate(string $url)
    {
        $response = $this->get($url);

        $response->assertStatus(200);
    }

    protected function paginateProvider()
    {
        return [
            ['api/clips/search'],
        ];
    }
}
