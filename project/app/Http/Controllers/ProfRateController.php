<?php

namespace App\Http\Controllers;

use Image;
use \App\Models\Professor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProfRateController extends Controller
{

    public function search(request $request)
    {
        /*
        //might works need professors to test with
        if ($request['profSearch'] == null || $request['profSearch'] == "")
        {
            return response()->json(array('emptyList' => true), 200);
        }
        $searchString = trim(filter_var($request['profSearch'], FILTER_SANITIZE_STRING));
        $records = Proseesor::select('name', 'id')->where('name', 'LIKE', "%{$searchString}%")
                ->where('id', '!=', Null);

        // if there are results
        if ($records->count() > 0)
        {
            return response()->json(array('users' => $records), 200);
        }
        */
        return view('profRate/search');
    }

    /* works as intended commented out for testing
    public function rate($Prof)
    {
        $prof = Professor::findOrFail($Prof);

        return view('profRate/rate', [
            'name' => $prof, 
            'faculty' => $prof,
        ]);
    } */

    //testing purposes only
    public function rate(){
     
        return view('profRate/rate');
    }

    //when adding a new rating to a professor
    public function store(request $request)
    {
        $rate = new Rating();
        $rate->rating = $request->rating;
        $rate->rated_by = $request->rated_by;
        $rate->professor_rated = $request->professor_rated;
        $rate->comments = $request->comments;
        $rate->class_taken = $request->class_taken;
        $rate->save();

        return view('profRate/rate');
    }
}
