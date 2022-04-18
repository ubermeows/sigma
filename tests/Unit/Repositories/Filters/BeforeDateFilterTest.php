<?php

namespace Tests\Unit\Repositories\Filters;

use Tests\TestCase;
use App\Models\Clip;
use App\Repositories\Filters\BeforeDateFilter;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class BeforeDateFilterTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider isApplicableDataProvider
     */
    public function is_applicable(bool $expected, array $arguments)
    {
        $isApplicable = (new BeforeDateFilter($arguments))->isApplicable();

        $this->assertEquals($expected, $isApplicable);
    }

    protected function isApplicableDataProvider(): array
    {
        return [
            [true, ['before_date' => '2022-01-01']],
            [false, []],
        ];
    }

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

        $arguments = ['before_date' => '2022-01-02 23:59:59'];

        $builder = Clip::query();

        (new BeforeDateFilter($arguments))->apply($builder);

        $items = $builder->get();

        $this->assertEquals(
            [1, 2], 
            $items->pluck('id')->toArray(),
        );
    }
}
