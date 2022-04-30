<?php

namespace Tests\Unit\Repositories\Filters;

use Tests\TestCase;
use App\Models\Clip;
use App\Repositories\Filters\LoadRelationsFilter;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class LoadRelationsFilterTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function apply()
    {
        $clip = Clip::factory()->create();

        $request = $this->mockRequest(query: [
            'relations' => ['game'],
        ]);

        $builder = Clip::query();

        (new LoadRelationsFilter($request))->apply($builder);

        $items = $builder->get();

        $this->assertTrue($items->first()->relationLoaded('game'));
    }
}
