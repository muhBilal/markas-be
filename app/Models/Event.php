<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function event_role()
    {
        return $this->belongsTo(EventRole::class);
    }

    public function event_album()
    {
        return $this->belongsTo(EventAlbum::class);
    }

    public function regional()
    {
        return $this->belongsTo(Regional::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function activity_type()
    {
        return $this->belongsTo(ActivityType::class);
    }
}
