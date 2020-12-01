<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Course;
use App\Models\Post;
use \App\Models\Professor;

class ClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $classes = Course::all();
        $professors = Professor::all();
        return view('Classes.index', compact('classes', 'professors'));
    }

    public function search()
    {
        return view('Classes/classSearch');
    }
    
    public function show($id)
    {
        $class = Course::findOrFail($id);
        $prof = Professor::findOrFail($class->taught_by);
        $posts = Post::where('course_id', $class->id);
        return view('Classes.class', compact('class', 'prof', 'posts'));
    }

    public function addClass(Request $request)
    {
        // create new course
        $class = new Course();
        // class name will have no spaces and be all caps
        $class->class_name = str_replace(' ', '', strtoupper($request->class_name));
        $class->taught_by = $request->taught_by;
        $class->semester = $request->semester;
        $class->year = (int)date("Y");
        $class->created_by = auth()->user()->id;
        $class->save();

        redirect(route('class.index'));
    }

    public function removeClass(Request $request)
    {
        $contact = Course::where('first_user', $request->class_name)
                            ->delete();
    }

}
