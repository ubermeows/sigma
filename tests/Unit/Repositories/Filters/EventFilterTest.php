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
     * @dataProvider isApplicableDataProvider
     */
    public function is_applicable(bool $expected, array $arguments)
    {
        $isApplicable = (new EventFilter($arguments))->isApplicable();

        $this->assertEquals($expected, $isApplicable);
    }

    protected function isApplicableDataProvider(): array
    {
        return [
            [true, ['event' => 'horrible_octobre_2019']],
            [false, []],
        ];
    }

    /**
     * @test
     * @dataProvider applyDataProvider
     */
    public function apply(string $attribute)
    {
        $event = Event::factory()
            ->has(Clip::factory())
            ->create();

        $arguments = ['event' => $event->{$attribute}];

        $builder = Clip::query();

        (new EventFilter($arguments))->apply($builder);

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
