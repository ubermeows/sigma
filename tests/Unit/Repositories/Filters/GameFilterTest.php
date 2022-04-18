<?php

namespace Tests\Unit\Repositories\Filters;

use Tests\TestCase;
use App\Models\Clip;
use App\Models\Game;
use App\Repositories\Filters\GameFilter;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class GameFilterTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider isApplicableDataProvider
     */
    public function is_applicable(bool $expected, array $arguments)
    {
        $isApplicable = (new GameFilter($arguments))->isApplicable();

        $this->assertEquals($expected, $isApplicable);
    }

    protected function isApplicableDataProvider(): array
    {
        return [
            [true, ['game' => 'stalker']],
            [false, []],
        ];
    }

    /**
     * @test
     * @dataProvider applyDataProvider
     */
    public function apply(string $attribute)
    {
        $game = Game::factory()
            ->has(Clip::factory())
            ->create();

        $arguments = ['game' => $game->{$attribute}];

        $builder = Clip::query();

        (new GameFilter($arguments))->apply($builder);

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
