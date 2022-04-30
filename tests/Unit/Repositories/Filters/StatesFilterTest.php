<?php

namespace Tests\Unit\Repositories\Filters;

use Tests\TestCase;
use App\Models\Clip;
use App\Enums\ClipStates;
use App\Repositories\Filters\StatesFilter;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class StatesFilterTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider applyDataProvider
     */
    public function apply(int $expected, array $states)
    {
        Clip::factory()
            ->count(2)
            ->state(new Sequence(
                ['state' => ClipStates::Active],
                ['state' => ClipStates::Suspect],
            ))
            ->create();

        $request = $this->mockRequest(query: ['states' => $states]);

        $builder = Clip::query();

        (new StatesFilter($request))->apply($builder);

        $items = $builder->get();

        $this->assertCount($expected, $items);
    }

    protected function applyDataProvider()
    {
        return [
            [1, [ClipStates::Active->value]],
            [1, [ClipStates::Suspect->value]],
            [2, [ClipStates::Active->value, ClipStates::Suspect->value]],
        ];
    }
}
