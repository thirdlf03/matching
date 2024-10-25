<?php

namespace Database\Factories;

use App\Models\Archive;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Archive>
 */
class ArchiveFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Archive::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
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
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
