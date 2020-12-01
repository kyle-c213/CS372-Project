<?php

namespace App\Http\Controllers;

use App\Models\ImportantDates;
use App\Models\ClassMember;
use Illuminate\Http\Request;

class ImportantDateController extends Controller
{
    // add an important date to a class
    public function add(Request $request)
    {
        // if user is not in class, add them
        if (ClassMember::where('user_id', auth()->user()->id)
                        ->where('course_id', $request->course_id)->get()->Count() <= 0)
        {
            $classMember = new ClassMember();
            $classMember->user_id = auth()->user()->id;
            $classMember->course_id = $request->course_id;

            $classMember->save();
        }

        // create event
        $event = new ImportantDates();
        $event->user_id = auth()->user()->id;
        $event->course_id = $request->course_id;
        $event->title = $request->title;
        $event->body = $request->body;
        $event->due_date = $request->due_date;
        $event->save();

        // return to event page
        return redirect(route('event.show', $event->id));     
    }

    // shows details for an important date
    public function show($id)
    {
        $event = ImportantDates::findOrFail($id);
        return view('ImportantDates.show', compact('event'));
    }
}
