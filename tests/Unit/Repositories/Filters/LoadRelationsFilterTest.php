<?php

namespace Tests\Unit\Repositories\Filters;

use Tests\TestCase;
use App\Models\Clip;
use App\Repositories\Filters\LoadRelationsFilter;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class LoadRelationsFilterTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider isApplicableDataProvider
     */
    public function is_applicable(bool $expected, array $arguments)
    {
        $isApplicable = (new LoadRelationsFilter($arguments))->isApplicable();

        $this->assertEquals($expected, $isApplicable);
    }

    protected function isApplicableDataProvider(): array
    {
        return [
            [true, ['relations' => 'game']],
            [false, []],
        ];
    }

    /**
     * @test
     */
    public function apply()
    {
        $clip = Clip::factory()->create();

        $arguments = [
            'relations' => ['game']
        ];

        $builder = Clip::query();

        (new LoadRelationsFilter($arguments))->apply($builder);

        $items = $builder->get();

        $this->assertTrue($items->first()->relationLoaded('game'));
    }
}
