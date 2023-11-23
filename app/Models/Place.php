<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function regional()
    {
        return $this->belongsTo(Regional::class);
    }

    public function facilities()
    {
        return $this->hasMany(PlaceFacility::class);
    }

    public function images()
    {
        return $this->hasMany(PlaceImage::class);
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'place_rooms');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'place_tags');
    }

    public function location_nearest_areas()
    {
        return $this->hasMany(LocationNearestArea::class);
    }
}
