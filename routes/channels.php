<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('my-channel.{userId}', function (User $user, $userId) {
    return $user->room_members()->where('user_id', $userId)->exists();
});
