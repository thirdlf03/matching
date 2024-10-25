<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomRole extends Model
{
    /** @use HasFactory<\Database\Factories\RoomRoleFactory> */
    use HasFactory;

     protected $fillable = ['user_id', 'room_id', 'role_name', 'status'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
