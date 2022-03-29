<?php

namespace Database\Factories;

use App\Models\Clip;
use App\Models\Game;
use App\Models\Creator;
use App\Enums\ClipStates;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clip>
 */
class ClipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'raw_id' => $this->faker->unique()->numberBetween(1000, 100000),
            'state' => ClipStates::Active->value,
            'url' => 'https://clips.twitch.tv/VibrantElegantClipsdadPJSalt-xx9LNEBxXConq7El',
            'title' => 'OUH Dans les couilles',
            'thumbnail_url' => 'https://clips-media-assets2.twitch.tv/45083375404-offset-4924-preview-480x272.jpg',
            'duration' => 26,
            'views' => 100,
            'published_at' => '2022-03-28T19:21:57Z',
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (Clip $clip) {
            if ($clip->creator()->doesntExist()) {
                $clip->creator()->associate(Creator::factory()->create());
            }
            if ($clip->game()->doesntExist()) {
                $clip->game()->associate(Game::factory()->create());
            }
        });
    }
}
