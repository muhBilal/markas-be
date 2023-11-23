<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with('place')->get();
        return response()->json([
            'status' => 'success',
            'data' => $testimonials
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'profile' => 'required',
            'company' => 'required',
            'location' => 'required',
            'place_id' => 'required',
            'message' => 'required',
            'rating' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $testimonial = Testimonial::create([
            'name' => $request->name,
            'profile' => $request->profile,
            'company' => $request->company,
            'location' => $request->location,
            'place_id' => $request->place_id,
            'message' => $request->message,
            'rating' => $request->rating,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Testimonial Created',
            'data' => $testimonial->load('place')
        ], 201);
    }

    public function show($id)
    {
        $testimonial = Testimonial::with('place')->find($id);

        if (!$testimonial) {
            return response()->json([
                'status' => 'error',
                'message' => 'Testimonial Not Found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Testimonial Found',
            'data' => $testimonial
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::find($id);

        if (!$testimonial) {
            return response()->json([
                'status' => 'error',
                'message' => 'Testimonial Not Found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'profile' => 'required',
            'company' => 'required',
            'location' => 'required',
            'place_id' => 'required',
            'message' => 'required',
            'rating' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $testimonial->update([
            'name' => $request->name,
            'profile' => $request->profile,
            'company' => $request->company,
            'location' => $request->location,
            'place_id' => $request->place_id,
            'message' => $request->message,
            'rating' => $request->rating,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Testimonial Updated',
            'data' => $testimonial
        ], 200);
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::find($id);

        if (!$testimonial) {
            return response()->json([
                'status' => 'error',
                'message' => 'Testimonial Not Found'
            ], 404);
        }

        $testimonial->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Testimonial Deleted'
        ], 200);
    }
}
