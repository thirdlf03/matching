<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Room>
 */
final class RoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Room::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'size' => fake()->randomNumber(),
            'title' => fake()->title,
            'data_json' => fake()->word,
            'latitude' => fake()->optional()->randomFloat(8, -90, 90),
            'longitude' => fake()->optional()->randomFloat(8, -180, 180),
        ];
    }
}
