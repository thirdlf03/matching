<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /** @use HasFactory<\Database\Factories\RoomFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'size',
        'title',
        'data_json',
        'latitude',
        'longitude',
        'category_id',
        'is_show',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room_members()
    {
        return $this->belongsToMany(User::class, 'room_members', 'room_id', 'user_id');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }
}
