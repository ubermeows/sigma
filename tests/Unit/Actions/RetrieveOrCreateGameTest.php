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

        $gameRetrieved = app(RetrieveOrCreateGame::class)->execute(new RawClip(
            game_id: $game->tracking_id,
        ));

        $this->assertFalse($gameRetrieved->wasRecentlyCreated);
        $this->assertTrue($game->is($gameRetrieved));
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
        $this->assertDatabaseHas('games', [
            'tracking_id' => '27284',
            'name' => 'Retro',
            'slug' => 'retro',
            'box_art_url' => 'https://static-cdn.jtvnw.net/ttv-boxart/27284-{width}x{height}.jpg',
        ]);
    }
}
