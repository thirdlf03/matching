<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Room;
use App\Models\User;
use App\Models\Category;
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
            'size' => $this->faker->randomNumber(),
            'title' => $this->faker->title,
            'data_json' => json_encode(['key' => 'value']), // Ensure this is valid JSON
            'latitude' => $this->faker->optional()->randomFloat(8, -90, 90),
            'longitude' => $this->faker->optional()->randomFloat(8, -180, 180),
            'category_id' => Category::factory(),
            'is_show' => $this->faker->boolean,
        ];
    }
}
