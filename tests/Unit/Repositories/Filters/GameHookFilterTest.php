<?php

namespace Tests\Unit\Repositories\Filters;

use Tests\TestCase;
use App\Models\Clip;
use App\Models\Game;
use App\Repositories\Filters\GameHookFilter;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class GameHookFilterTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider applyDataProvider
     */
    public function apply(string $attribute)
    {
        $game = Game::factory()
            ->has(Clip::factory())
            ->create();

        $request = $this->mockRequest(query: [
            'game' => $game->{$attribute},
        ]);

        $builder = Clip::query();

        (new GameHookFilter($request))->apply($builder);

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
