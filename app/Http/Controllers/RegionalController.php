<?php

namespace App\Http\Controllers;

use App\Models\Regional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regionals = Regional::all();
        return response()->json([
            'status' => 'success',
            'data'    => $regionals
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
        $regional = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($regional->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $regional->errors()
            ], 422);
        }

        $regional = Regional::create([
            'name' => ucwords($request->name)
        ]);

        if ($regional) {
            return response()->json([
                'status' => 'success',
                'message' => 'Regional created successfully',
                'data'    => $regional
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $regional = Regional::find($id);

        if ($regional) {
            return response()->json([
                'status' => 'success',
                'message' => 'Show regional successfully',
                'data'    => $regional
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Regional not found'
        ], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Regional $regional)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $regional = Regional::find($id);

        if ($regional) {

            $validator = Validator::make($request->all(), [
                'name' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $regional->errors()
                ], 422);
            }

            $regional->update([
                'name' => ucwords($request->name)
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Regional updated successfully',
                'data'    => $regional
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Regional not found'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $regional = Regional::find($id);

        if ($regional) {
            $regional->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Regional deleted successfully'
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Regional not found'
        ], 404);
    }
}
