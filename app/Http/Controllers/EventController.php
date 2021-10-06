<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    
    public function index()
    {
        if(request()->ajax()){
            $events = Event::whereDate('start','>=',request()->start)
                            ->whereDate('end','<=',request()->end)
                            ->get();

            return response()->json($events);
        }

        return view('events');
    }
    
    public function store(EventRequest $request)
    {
        if($request->ajax()){
            $event = Event::create([
                'title' => $request->title,
                'start' => $request->start,
                'end' => $request->end,
            ]);

            return response()->json($event);
        }
        
    }

    public function update(EventRequest $request)
    {
        if($request->ajax()){
            $event = Event::find($request->id)->update([
                'title' => $request->title,
                'start' => $request->start,
                'end' => $request->end,
            ]);

            return response()->json($event);
        }
    }

    public function destroy(Request $request)
    {
        if($request->ajax()){
            $event = Event::find($request->id)->delete();

            return response()->json($event);
        }
    }
}
