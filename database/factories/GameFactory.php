<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
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
            'name' => $this->faker->unique()->name(),
            'slug' => function (array $attributes) {
                return Str::slug($attributes['name']);
            },
            'box_art_url' => function (array $attributes) {

                $boxArtUrl = preg_replace(
                    '#{raw_id}#', 
                    $attributes['raw_id'], 
                    'https://static-cdn.jtvnw.net/ttv-boxart/{raw_id}-{width}x{height}.jpg',
                );

                return $boxArtUrl;
            },
        ];
    }
}
