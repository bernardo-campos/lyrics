<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\Song;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Song>
 */
class SongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'album_id' => Album::factory(),
            'number' => function (array $attributes) {
                return Song::where('album_id', $attributes['album_id'])->count() + 1;
            },
            'name' => $this->faker->sentence(),
            'lyric' => implode('. ', $this->faker->paragraphs()),
        ];
    }
}
