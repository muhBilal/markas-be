<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data'    => RoomType::all()
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $room_type = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($room_type->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $room_type->errors()
            ], 422);
        }

        $room_type = RoomType::create([
            'name' => strtoupper($request->name)
        ]);

        if ($room_type) {
            return response()->json([
                'status' => 'success',
                'message' => 'Room type created successfully',
                'data'    => $room_type
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $room_type = RoomType::find($id);

        if ($room_type) {
            return response()->json([
                'status' => 'success',
                'message' => 'Show room type successfully',
                'data'    => $room_type
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Room type not found'
        ], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoomType $roomType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $room_type = RoomType::find($id);

        if ($room_type) {

            $validator = Validator::make($request->all(), [
                'name' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $room_type->errors()
                ], 422);
            }

            $room_type->update([
                'name' => strtoupper($request->name)
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Room type updated successfully',
                'data'    => $room_type
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Room type not found'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $room_type = RoomType::find($id);

        if ($room_type) {
            $room_type->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Room type deleted successfully'
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Room type not found'
        ], 404);
    }
}
