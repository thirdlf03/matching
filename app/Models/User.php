<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\User;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function room_members()
    {
        return $this->belongsToMany(Room::class, 'room_members', 'user_id', 'room_id');
    }
    public function follows()
  {
    return $this->belongsToMany(User::class, 'follows', 'follow_id', 'follower_id');
  }

  public function followers()
  {
    return $this->belongsToMany(User::class, 'follows', 'follower_id', 'follow_id');
  }
}
