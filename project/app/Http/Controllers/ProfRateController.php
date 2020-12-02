<?php

namespace App\Http\Controllers;

use Image;
use \App\Models\Professor;
use \App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProfRateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //searchs for professor names to link to their rating page
    public function search2(request $request)
    {
        if ($request['searchString'] == null || $request['searchString'] == "")
        {
            return response()->json(array('emptyList' => true), 200);
        }
        $searchString = trim(filter_var($request['searchString'], FILTER_SANITIZE_STRING));
        $records = Professor::select('name', 'id')->where('name', 'LIKE', "%{$searchString}%")->get();

        // if there are results
        if ($records->count() > 0)
        {
            return response()->json(array('professors' => $records), 200);
        } 
    }

    //displays the search page
    public function search(request $request)
    {
        return view('profRate.search');
    }

    //link to prof rating page
    public function rate($prof_id){

        $prof = Professor::findorfail($prof_id);

        $records = Rating::where('professor_rated', $prof_id)->get();

        // if there are results
        if ($records->count() > 0)
        {
            $total=0;
            foreach($records as $rating)
            {
                $total += $rating->rating;
            }
            $avg=$total/$records->count();
        } else {
            $avg=-1;
        }

        //dd($records); //for testing

        $avg = number_format((float)$avg, 2, '.', '');

        return view('profRate.rate', compact('records', 'prof'))->with('avgRate', $avg);
    }

    //to add a new professor to db
    public function create()
    {
        return view('profRate.create');
    }

    //when adding a new rating to a professor
    public function store(Request $request)
    {
        //data validation from form for ratings
        /*
        * note: the validation works as intended but if
        * using XAMPP when working locally the validation
        * does not appear on the site.
        * PROOF:https://laravel.io/forum/why-laravel-validation-dont-displaying-errors
        */
        $data = $request->validate([
            'name' => ['required', 'string'],
            'faculty' => ['required', 'string'],
        ]);

        $prof = new Professor();//new Professor variable
        $prof->name = $request->name; //gets professor's name from name field in form
        $prof->faculty = $request->faculty; //gets professor's faculty from faculty field in form
        $prof->save(); //saves professor information to database

        return redirect(route('profRate.show',$prof->id)); //redirect to rate Professor
    }
}
