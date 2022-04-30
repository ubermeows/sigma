<?php

namespace Tests\Unit\Repositories\Filters;

use Tests\TestCase;
use App\Models\Clip;
use App\Repositories\Filters\RandomizerFilter;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class RandomizerFilterTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function apply()
    {
        $clips = Clip::factory()
            ->count(30)
            ->create();

        $request = $this->mockRequest(query: ['random' => true]);

        $builder = Clip::query();

        (new RandomizerFilter($request))->apply($builder);

        $items = $builder->get();

        $this->assertNotEquals(
            $clips->pluck('id'),
            $items->pluck('id'),
        );
    }
}
