<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Course;

class ClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function search()
    {
        return view('Classes/classSearch');
    }
    
     public function show()
    {
        return view('Classes.class');
    }

    public function addClass(Request $request)
    {
        $class = new Course();
        $class->class_name = $request->class_name;
        $class->save();
    }

    public function removeClass(Request $request)
    {
        $contact = Course::where('first_user', $request->class_name)
                            ->delete();
    }
}
