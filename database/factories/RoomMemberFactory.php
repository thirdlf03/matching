<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Room;
use App\Models\RoomMember;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\RoomMember>
 */
final class RoomMemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RoomMember::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'room_id' => Room::factory(),
            'user_id' => User::factory(),
            'status' => fake()->randomNumber(),
        ];
    }
}
