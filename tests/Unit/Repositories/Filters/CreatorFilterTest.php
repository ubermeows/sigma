<?php

namespace Tests\Unit\Repositories\Filters;

use Tests\TestCase;
use App\Models\Clip;
use App\Models\Creator;
use App\Repositories\Filters\CreatorFilter;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class CreatorFilterTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider applyDataProvider
     */
    public function apply(string $attribute)
    {
        $creator = Creator::factory()
            ->has(Clip::factory())
            ->create();

        $request = $this->mockRequest(query: ['creator' => $creator->{$attribute}]);

        $builder = Clip::query();

        (new CreatorFilter($request))->apply($builder);

        $items = $builder->get();

        $this->assertCount(1, $items);
    }

    protected function applyDataProvider()
    {
        return [
            ['id'],
            ['tracking_id'],
            ['slug'],
        ];
    }
}
