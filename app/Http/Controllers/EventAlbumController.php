<?php

namespace App\Http\Controllers;

use App\Models\EventAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventAlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data'    => EventAlbum::all()
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
        $event_album = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($event_album->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $event_album->errors()
            ], 422);
        }

        $event_album = EventAlbum::create([
            'name' => strtoupper($request->name)
        ]);

        if ($event_album) {
            return response()->json([
                'status' => 'success',
                'message' => 'Event album created successfully',
                'data'    => $event_album
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $event_album = EventAlbum::find($id);

        if ($event_album) {
            return response()->json([
                'status' => 'success',
                'message' => 'Show event album successfully',
                'data'    => $event_album
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Event album not found'
        ], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventAlbum $eventAlbum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $event_album = EventAlbum::find($id);

        if ($event_album) {

            $validator = Validator::make($request->all(), [
                'name' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $event_album->errors()
                ], 422);
            }

            $event_album->update([
                'name' => strtoupper($request->name)
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Event album updated successfully',
                'data'    => $event_album
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Event album not found'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $event_album = EventAlbum::find($id);

        if ($event_album) {
            $event_album->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Event album deleted successfully'
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Event album not found'
        ], 404);
    }
}
