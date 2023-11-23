<?php

namespace App\Http\Controllers;

use App\Models\LocationNearestArea;
use App\Models\Place;
use App\Models\PlaceFacility;
use App\Models\PlaceImage;
use App\Models\PlaceTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PlaceController extends Controller
{
    public function index()
    {
        $places = Place::all();

        return response()->json([
            'status' => 'success',
            'data' => $places
        ], 200);
    }

    public function show($id)
    {
        $place = Place::find($id);
        $placeImages = PlaceImage::where('place_id', $id)->get();
        $placeTags = PlaceTag::where('place_id', $id)->get();
        $placeFacilities = PlaceFacility::where('place_id', $id)->get();
        $locationNarest = LocationNearestArea::where('place_id', $id)->get();

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
            'data' => [
                'place' => $place,
                'placeImages' => $placeImages,
                'placeTags' => $placeTags,
                'placeFacilities' => $placeFacilities,
                'locationNarest' => $locationNarest
            ]
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
            'tags' => 'required|array',
            'tags.*.id' => 'required',
            'tags.*.name' => 'required',
            'place_images' => 'required|array',
            'place_images.*.id' => 'required',
            'place_images.*.place_id' => 'required',
            'place_images.*.image' => 'required',
            'place_facilities' => 'required|array',
            'place_facilities.*.id' => 'required',
            'place_facilities.*.place_id' => 'required',
            'place_facilities.*.name' => 'required',
            'place_tags' => 'required|array',
            'place_tags.*.id' => 'required',
            'place_tags.*.place_id' => 'required',
            'place_tags.*.tag_id' => 'required',
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

            if ($request->has('tags')) {
                foreach ($request->tags as $tagData) {
                    $tag = Tag::create([
                        'id' => $tagData['id'],
                        'name' => $tagData['name'],
                    ]);
                    $place->tags()->attach($tag->id);
                }
            }

            if ($request->has('place_images')) {
                foreach ($request->place_images as $imageData) {
                    $placeImage = PlaceImage::create([
                        'id' => $imageData['id'],
                        'place_id' => $place->id,
                        'image' => $imageData['image'],
                    ]);
                }
            }

            if ($request->has('place_facilities')) {
                foreach ($request->place_facilities as $facilityData) {
                    $placeFacility = PlaceFacility::create([
                        'id' => $facilityData['id'],
                        'place_id' => $place->id,
                        'name' => $facilityData['name'],
                    ]);
                }
            }

            if ($request->has('place_tags')) {
                foreach ($request->place_tags as $placeTagData) {
                    $placeTag = PlaceTag::create([
                        'id' => $placeTagData['id'],
                        'place_id' => $place->id,
                        'tag_id' => $placeTagData['tag_id'],
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Place created successfully',
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to store data. ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'regional_id' => 'required',
            'title' => 'required',
            'address' => 'required',
            'price' => 'required',
            'address_url' => 'required',
            'tags' => 'required|array',
            'tags.*.id' => 'required',
            'tags.*.name' => 'required',
            'place_images' => 'required|array',
            'place_images.*.id' => 'required',
            'place_images.*.place_id' => 'required',
            'place_images.*.image' => 'required',
            'place_facilities' => 'required|array',
            'place_facilities.*.id' => 'required',
            'place_facilities.*.place_id' => 'required',
            'place_facilities.*.name' => 'required',
            'place_tags' => 'required|array',
            'place_tags.*.id' => 'required',
            'place_tags.*.place_id' => 'required',
            'place_tags.*.tag_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $place = Place::findOrFail($id);
            $place->update([
                'regional_id' => $request->regional_id,
                'title' => $request->title,
                'address' => $request->address,
                'price' => $request->price,
                'address_url' => $request->address_url,
            ]);

            $placeTags = PlaceTag::where('place_id', $id)->get();
            $tagIds = $placeTags->pluck('tag_id')->toArray();
            Tag::whereIn('id', $tagIds)->delete();
            PlaceImage::where('place_id', $id)->delete();
            PlaceFacility::where('place_id', $id)->delete();
            $placeTags->delete();
            $place->location_nearest_area;

            if ($request->has('tags')) {
                foreach ($request->tags as $tagData) {
                    $tag = Tag::create([
                        'id' => $tagData['id'],
                        'name' => $tagData['name'],
                    ]);
                    $place->tags()->attach($tag->id);
                }
            }

            if ($request->has('place_images')) {
                foreach ($request->place_images as $imageData) {
                    $placeImage = PlaceImage::create([
                        'id' => $imageData['id'],
                        'place_id' => $place->id,
                        'image' => $imageData['image'],
                    ]);
                }
            }

            if ($request->has('place_facilities')) {
                foreach ($request->place_facilities as $facilityData) {
                    $placeFacility = PlaceFacility::create([
                        'id' => $facilityData['id'],
                        'place_id' => $place->id,
                        'name' => $facilityData['name'],
                    ]);
                }
            }

            if ($request->has('place_tags')) {
                foreach ($request->place_tags as $placeTagData) {
                    $placeTag = PlaceTag::create([
                        'id' => $placeTagData['id'],
                        'place_id' => $place->id,
                        'tag_id' => $placeTagData['tag_id'],
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Place updated successfully'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update data. ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $place = Place::find($id);

        if (!$place) {
            return response()->json([
                'status' => '404',
                'message' => 'Not Found',
                'data' => null
            ], 404);
        }

        try {
            DB::beginTransaction();
            $placeTags = PlaceTag::where('place_id', $id)->get();
            $tagIds = $placeTags->pluck('tag_id')->toArray();
            Tag::whereIn('id', $tagIds)->delete();
            PlaceImage::where('place_id', $id)->delete();
            PlaceFacility::where('place_id', $id)->delete();
            $placeTags->delete();
            $place->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete data. ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Place deleted successfully',
            'data' => null
        ], 200);
    }
}
