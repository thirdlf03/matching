<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    /** @use HasFactory<\Database\Factories\CalendarFactory> */
    use HasFactory;

    //protected $fillable = [
        //'room_id',
        //'date',
    //];

    public function rooms()
    {
        //return $this->hasMany(Room::class);
    }
}
