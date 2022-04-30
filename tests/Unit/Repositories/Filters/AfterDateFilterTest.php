<?php

namespace Tests\Unit\Repositories\Filters;

use Tests\TestCase;
use App\Models\Clip;
use Illuminate\Http\Request;
use App\Repositories\Filters\AfterDateFilter;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseMigrations; 


class AfterDateFilterTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function apply()
    {
        Clip::factory()
            ->count(3)
            ->state(new Sequence(
                ['published_at' => '2022-01-01'],
                ['published_at' => '2022-01-02'],
                ['published_at' => '2022-01-03'],
            ))
            ->create();

        $request = $this->mockRequest(query: ['after_date' => '2022-01-02']);

        $builder = Clip::query();

        (new AfterDateFilter($request))->apply($builder);

        $items = $builder->get();

        $this->assertEquals(
            [2, 3], 
            $items->pluck('id')->toArray()
        );
    }
}
