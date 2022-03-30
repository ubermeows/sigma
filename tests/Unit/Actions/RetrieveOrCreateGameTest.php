<?php

namespace Tests\Unit\Actions;

use Tests\TestCase;
use App\Models\Game;
use App\Dtos\RawClip;
use App\Actions\RetrieveOrCreateGame;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class RetrieveOrCreateGameTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function retrieve_game()
    {
        $game = Game::factory()->create();

        $retrievedGame = app(RetrieveOrCreateGame::class)->execute(new RawClip(
            game_id: $game->tracking_id,
        ));

        $this->assertFalse($retrievedGame->wasRecentlyCreated);

        $this->assertTrue($game->is($retrievedGame));
    }

    /**
     * @test
     */
    public function create_game()
    {
        $game = app(RetrieveOrCreateGame::class)->execute(new RawClip(
            game_id: '508289',
        ));

        $this->assertTrue($game->wasRecentlyCreated);

        $this->assertEquals([
            'tracking_id' => '27284',
            'name' => 'Retro',
            'slug' => 'retro',
            'box_art_url' => 'https://static-cdn.jtvnw.net/ttv-boxart/27284-{width}x{height}.jpg',
        ], $game->only('tracking_id', 'name', 'slug', 'box_art_url'));
    }
}
