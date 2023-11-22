<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('event_role', 'event_album', 'regional', 'room', 'activity_type')->get();
        return response()->json([
            'status' => 'success',
            'data' => $events
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'episode' => 'required',
            'title' => 'required',
            'sub_title' => 'required',
            'description' => 'required',
            'event_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'event_role_id' => 'required',
            'event_album_id' => 'required',
            'regional_id' => 'required',
            'speaker_name' => 'required',
            'speaker_desc' => 'required',
            'speaker_image' => 'required',
            'room_id' => 'required',
            'activity_type_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 422);
        }

        $image_path = $request->file('speaker_image')->store('event-speaker-images');

        $data = [
            'episode' => $request->episode,
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'event_role_id' => $request->event_role_id,
            'event_album_id' => $request->event_album_id,
            'regional_id' => $request->regional_id,
            'speaker_name' => $request->speaker_name,
            'speaker_desc' => $request->speaker_desc,
            'speaker_image' => $image_path,
            'room_id' => $request->room_id,
            'activity_type_id' => $request->activity_type_id
        ];


        $event = Event::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Event created successfully',
            'data' => $event->load('event_role', 'event_album', 'regional', 'room', 'activity_type')
        ]);
    }

    public function show($id)
    {

        $event = Event::with('event_role', 'event_album', 'regional', 'room', 'activity_type')->find($id);
        if (!$event) {
            return response()->json([
                'status' => 'error',
                'message' => 'Event not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $event
        ]);
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json([
                'status' => 'error',
                'message' => 'Event not found'
            ], 404);
        }

        $event->delete();
        Storage::delete($event->speaker_image);

        return response()->json([
            'status' => 'success',
            'message' => 'Event deleted successfully'
        ]);
    }
}
