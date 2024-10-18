<?php

use App\Models\Room;
use App\Models\User;

it('retrieves all rooms', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $room = Room::factory()->create();

    $response = $this->get('/rooms');

    $response->assertStatus(200);
    $response->assertViewHas('rooms', function ($rooms) use ($room) {
        return $rooms->contains($room);
    });
});

it('displays the create room page', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->get('/rooms/create');

    $response->assertStatus(200);
    $response->assertViewMissing('');
});

it('allows authenticated users to create a room', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $roomData = [
        'user_id' => $user->id,
        'size' => 2,
        'title' => 'test',
        'data_json' => json_encode(['data' => 'test']),
        'latitude' => 51.12345,
        'longitude' => 120.00112,
    ];

    $response = $this->post('/rooms', $roomData);

    $this->assertDatabaseHas('rooms', [
        'user_id' => $user->id,
        'size' => 2,
        'title' => 'test',
        'data_json' => $roomData['data_json'],
        'latitude' => 51.12345,
        'longitude' => 120.00112,
    ]);

    $response->assertStatus(302);
    $response->assertRedirect('/rooms');
});
