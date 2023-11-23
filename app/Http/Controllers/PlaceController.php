<?php

namespace App\Http\Controllers;

use App\Models\LocationNearestArea;
use App\Models\Place;
use App\Models\PlaceFacility;
use App\Models\PlaceImage;
use App\Models\PlaceRoom;
use App\Models\PlaceTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PlaceController extends Controller
{
    public function index()
    {
        $places = Place::with(['regional', 'facilities', 'images', 'rooms', 'tags', 'location_nearest_areas'])->get();

        return response()->json([
            'status' => 'success',
            'data' => $places
        ], 200);
    }

    public function show($id)
    {
        $place = Place::with(['regional', 'facilities', 'images', 'rooms', 'tags', 'location_nearest_areas'])->find($id);

        if (!$place) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not Found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Place found successfully',
            'data' => $place
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'regional_id' => 'required',
            'title' => 'required',
            'address' => 'required',
            'price' => 'required',
            'address_url' => 'required',
            'place_images' => 'required|array',
            'place_facilities' => 'required|array',
            'place_tags' => 'required|array',
            'place_rooms' => 'required|array',
            'location_nearest_areas' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $place = Place::create([
                'regional_id' => $request->regional_id,
                'title' => $request->title,
                'address' => $request->address,
                'price' => $request->price,
                'address_url' => $request->address_url,
            ]);

            if ($request->has('place_images')) {
                foreach ($request->file('place_images') as $key => $place_image) {
                    $place_image_path = $place_image->store('place-images');
                    PlaceImage::create([
                        'place_id' => $place->id,
                        'image' => $place_image_path,
                    ]);
                }
            }

            if ($request->has('place_facilities')) {
                foreach ($request->place_facilities as $facilityData) {
                    PlaceFacility::create([
                        'place_id' => $place->id,
                        'name' => $facilityData,
                    ]);
                }
            }

            if ($request->has('place_tags')) {
                foreach ($request->place_tags as $placeTagData) {
                    PlaceTag::create([
                        'place_id' => $place->id,
                        'tag_id' => $placeTagData,
                    ]);
                }
            }

            if ($request->has('place_rooms')) {
                foreach ($request->place_rooms as $placeRoomData) {
                    PlaceRoom::create([
                        'place_id' => $place->id,
                        'room_id' => $placeRoomData,
                    ]);
                }
            }

            if ($request->has('location_nearest_areas')) {
                foreach ($request->location_nearest_areas as $locationNearestAreaData) {
                    LocationNearestArea::create([
                        'place_id' => $place->id,
                        'name' => $locationNearestAreaData['name'],
                        'desc' => $locationNearestAreaData['desc'],
                        'time' => $locationNearestAreaData['time'],
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Place created successfully',
                'data' => $place->load(['regional', 'facilities', 'images', 'rooms', 'tags', 'location_nearest_areas'])
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to store data. ' . $e->getMessage()
            ], 500);
        }
    }
}
