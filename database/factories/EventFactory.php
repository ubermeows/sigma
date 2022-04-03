<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'tracking_id' => $this->faker->unique()->numberBetween(1000, 100000),
            'name' => $this->faker->unique()->name(),
            'slug' => function (array $attributes) {
                return Str::slug($attributes['name']);
            },
        ];
    }
}
