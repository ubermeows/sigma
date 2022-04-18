<?php

namespace Tests\Unit\Repositories\Filters;

use Tests\TestCase;
use App\Models\Clip;
use App\Repositories\Filters\OrderByFilter;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class OrderByFilterTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider isApplicableDataProvider
     */
    public function is_applicable(bool $expected, array $arguments)
    {
        $isApplicable = (new OrderByFilter($arguments))->isApplicable();

        $this->assertEquals($expected, $isApplicable);
    }

    protected function isApplicableDataProvider(): array
    {
        return [
            [true, ['sort' => 'created_at', 'order' => 'DESC']],
            [false, ['sort' => 'created_at']],
            [false, ['order' => 'DESC']],
        ];
    }

    /**
     * @test
     */
    public function apply()
    {
        $clips = Clip::factory()
            ->count(3)
            ->state(new Sequence(
                ['published_at' => '2022-01-01'],
                ['published_at' => '2022-01-02'],
                ['published_at' => '2022-01-03'],
            ))
            ->create();

        $arguments = [
            'sort' => 'published_at',
            'order' => 'DESC',
        ];

        $builder = Clip::query();

        (new OrderByFilter($arguments))->apply($builder);

        $items = $builder->get();

        $this->assertEquals(
            [3, 2, 1], 
            $items->pluck('id')->toArray()
        );
    }
}
