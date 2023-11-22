<?php

namespace App\Http\Controllers;

use App\Models\ActivityType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActivityTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data'    => ActivityType::all()
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
        $activity_type = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($activity_type->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $activity_type->errors()
            ], 422);
        }

        $activity_type = ActivityType::create([
            'name' => ucwords($request->name)
        ]);

        if ($activity_type) {
            return response()->json([
                'status' => 'success',
                'message' => 'Activity type created successfully',
                'data'    => $activity_type
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $activity_type = ActivityType::find($id);

        if ($activity_type) {
            return response()->json([
                'status' => 'success',
                'message' => 'Show activity type successfully',
                'data'    => $activity_type
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Activity type not found'
        ], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActivityType $ActivityType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $activity_type = ActivityType::find($id);

        if ($activity_type) {

            $validator = Validator::make($request->all(), [
                'name' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $activity_type->errors()
                ], 422);
            }

            $activity_type->update([
                'name' => ucwords($request->name)
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Activity type updated successfully',
                'data'    => $activity_type
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Activity type not found'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $activity_type = ActivityType::find($id);

        if ($activity_type) {
            $activity_type->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Activity type deleted successfully'
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Activity type not found'
        ], 404);
    }
}
