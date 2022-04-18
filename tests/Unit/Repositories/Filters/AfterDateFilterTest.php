<?php

namespace Tests\Unit\Repositories\Filters;

use Tests\TestCase;
use App\Models\Clip;
use App\Repositories\Filters\AfterDateFilter;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class AfterDateFilterTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider isApplicableDataProvider
     */
    public function is_applicable(bool $expected, array $arguments)
    {
        $isApplicable = (new AfterDateFilter($arguments))->isApplicable();

        $this->assertEquals($expected, $isApplicable);
    }

    protected function isApplicableDataProvider(): array
    {
        return [
            [true, ['after_date' => '2022-01-01']],
            [false, []],
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

        $arguments = ['after_date' => '2022-01-02'];

        $builder = Clip::query();

        (new AfterDateFilter($arguments))->apply($builder);

        $items = $builder->get();

        $this->assertEquals(
            [2, 3], 
            $items->pluck('id')->toArray()
        );
    }
}
