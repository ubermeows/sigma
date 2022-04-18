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
     * @dataProvider isApplicableDataProvider
     */
    public function is_applicable(bool $expected, array $arguments)
    {
        $isApplicable = (new RandomizerFilter($arguments))->isApplicable();

        $this->assertEquals($expected, $isApplicable);
    }

    protected function isApplicableDataProvider(): array
    {
        return [
            [true, ['random' => true]],
            [false, []],
        ];
    }

    /**
     * @test
     */
    public function apply()
    {
        $clips = Clip::factory()
            ->count(30)
            ->create();

        $arguments = [
            'random' => true,
        ];

        $builder = Clip::query();

        (new RandomizerFilter($arguments))->apply($builder);

        $items = $builder->get();

        $this->assertNotEquals(
            $clips->pluck('id'),
            $items->pluck('id'),
        );
    }
}
