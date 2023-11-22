<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomFacility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{

    public function index()
    {
        $rooms = Room::with('room_type', 'room_facilities')->get();
        return response()->json([
            'status' => 'success',
            'data' => $rooms
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_type_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'image' => 'required',
            'max_capacity' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $image_path = $request->file('image')->store('room-images');

        $data = [
            'room_type_id' => $request->room_type_id,
            'name' => strtoupper($request->name),
            'description' => $request->description,
            'image' => $image_path,
            'max_capacity' => $request->max_capacity,
        ];


        $room = Room::create($data);
        $room_facilities = $request->room_facilities;
        foreach ($room_facilities as $facility) {
            RoomFacility::create([
                'room_id' => $room->id,
                'name' => ucwords($facility)
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Room created successfully',
            'data' => $room->load('room_type', 'room_facilities')
        ]);
    }

    public function destroy($id)
    {
        $room = Room::find($id);
        if (!$room) {
            return response()->json([
                'status' => 'error',
                'message' => 'Room not found'
            ], 404);
        }

        $room->delete();
        Storage::delete($room->image);

        return response()->json([
            'status' => 'success',
            'message' => 'Room deleted successfully'
        ]);
    }
}
