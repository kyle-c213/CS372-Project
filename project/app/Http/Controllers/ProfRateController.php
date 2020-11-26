<?php

namespace App\Http\Controllers;

use Image;
use \App\Models\Professor;
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
        if ($request['profSearch'] == null || $request['searchString'] == "")
        {
            return response()->json(array('emptyList' => true), 200);
        }
        $searchString = trim(filter_var($request['profSearch'], FILTER_SANITIZE_STRING));
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
    public function rate($prof){

        $prof = Professor::findorfail($prof);
     
        return view('profRate.rate', [
            'prof' => $prof
        ]);
    }

    //toadd a new professor to db
    public function create()
    {
        return view('profRate.create');
    }

    //when adding a new rating to a professor
    public function store(request $request)
    {
        $prof = new Professor();//new Professor variable
        $prof->name = $request->name; //gets professor's name from name field in form
        $prof->faculty = $request->faculty; //gets professor's faculty from faculty field in form
        $prof->save(); //saves professor information to database

        return redirect(route('profRate.show',$prof->id)); //redirect to rate Professor
    }
}
