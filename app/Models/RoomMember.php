<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomMember extends Model
{
    /** @use HasFactory<\Database\Factories\RoomMemberFactory> */
    use HasFactory;

    protected $fillable = [
        'room_id',
        'user_id',
        'status',
    ];
}
