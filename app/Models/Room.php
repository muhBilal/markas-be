<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function room_type()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function room_facilities()
    {
        return $this->hasMany(RoomFacility::class);
    }
}
