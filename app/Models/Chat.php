<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    /** @use HasFactory<\Database\Factories\ChatFactory> */
    use HasFactory;

    protected $fillable = [
        'room_id',
        'user_id',
        'chat',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
