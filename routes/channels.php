<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;

Broadcast::channel('my-channel.{userId}', function (User $user, $userId) {
    return $user->room_members()->where('user_id', $userId)->exists();
});
