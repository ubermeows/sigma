<?php

namespace Tests\Unit\Repositories\Filters;

use Tests\TestCase;
use App\Models\Clip;
use App\Models\Event;
use App\Repositories\Filters\EventFilter;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class EventFilterTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider applyDataProvider
     */
    public function apply(string $attribute)
    {
        $event = Event::factory()
            ->has(Clip::factory())
            ->create();

        $request = $this->mockRequest(query: ['event' => $event->{$attribute}]);

        $builder = Clip::query();

        (new EventFilter($request))->apply($builder);

        $items = $builder->get();

        $this->assertCount(1, $items);
    }

    protected function applyDataProvider()
    {
        return [
            ['id'],
            ['slug'],
        ];
    }
}
