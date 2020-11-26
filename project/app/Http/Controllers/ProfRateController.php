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

    public function search(request $request)
    {
        //START OF BROKEN
/*        if ($request['profSearch'] == null || $request['profSearch'] == "")
        {
            return response()->json(array('emptyList' => true), 200);
        }
        $searchString = trim(filter_var($request['profSearch'], FILTER_SANITIZE_STRING));
        $records = Professor::select('name', 'id')->where('name', 'LIKE', "%{$searchString}%")->where('id', '!=', Null)->where()->take(5)->get();

        // if there are results
        if ($records->count() > 0)
        {
            return view('profRate.rate', compact($professors))'professors';
        }
*/        //END OF BROKEN

        return view('profRate.search');
    }

    //testing purposes only
    public function rate(){
     
        return view('profRate.rate');
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
