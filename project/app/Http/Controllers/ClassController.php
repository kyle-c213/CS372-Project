<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Course;
use App\Models\Post;
use \App\Models\Professor;
use \App\Models\ClassMember;
use App\Models\ImportantDates;
use App\Models\Listing;

class ClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // get classes user has joined
        $user_joined_classes = ClassMember::select('course_id')->where('user_id', auth()->user()->id)->get();
        $user_classes = array();
        foreach($user_joined_classes as $u=>$val)
        {
            array_push($user_classes, Course::where('id', $val->course_id)->first());
        }

        if (count($user_classes) <= 0)
        {
            return redirect(route('class.all'));
        }

        $professors = Professor::all();
        return view('Classes.index', compact('professors', 'user_classes'));
    }

    public function allClasses()
    {
        $classes = Course::orderBy('created_at')->get();
        return view('Classes.all', compact('classes'));
    }

    public function search()
    {
        // empty records as there are no search results yet
        $records = array();
        return view('Classes/classSearch', compact('records'));
    }

    public function search_post(Request $request)
    {
        if ($request->search == null || $request->search == "")
        {
            return redirect(route('class.search'));
        }
        $searchString = trim(filter_var($request->search, FILTER_SANITIZE_STRING));
        $records = Course::where('class_name', 'LIKE', "%{$searchString}%")->get();

        // if there are results
        if ($records->count() > 0)
        {
            return view('Classes/classSearch', compact('records'));
        }
    }
    
    public function show($id)
    {
        $class = Course::findOrFail($id);
        $prof = Professor::findOrFail($class->taught_by);
        $posts = Post::where('course_id', $class->id)->get();
        $members = ClassMember::where('course_id', $class->id)->get();
        $listings = Listing::where('course_id', $class->id)->where('deleted', false)->where('sold', false)->get();
        $events = ImportantDates::where('course_id', $class->id)->where('due_date', '>=', strtotime('now'))->orderBy('due_date', "ASC")->get();
        return view('Classes.class', compact('class', 'prof', 'posts', 'members', 'listings', 'events'));
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

        // add creator as a class member
        $member = new ClassMember();
        $member->user_id = $class->created_by;
        $member->course_id = $class->id;
        $member->save();

        return redirect(route('class.index'));
    }

    public function removeClass(Request $request)
    {
        $contact = Course::where('first_user', $request->class_name)
                            ->delete();
    }

    public function joinClass($class_id)
    {
        // check if user has already joined class
        if (ClassMember::where('user_id', auth()->user()->id)
                        ->where('course_id', $class_id)->get()->Count() <= 0)
        {
            // create new class member for passed class
            $classMember = new ClassMember();
            $classMember->user_id = auth()->user()->id;
            $classMember->course_id = $class_id;

            $classMember->save();
        }
        return redirect(route('class.show', $class_id));
    }

    public function leaveClass($class_id)
    {
        // check if user can leave the class
        if (ClassMember::where('user_id', auth()->user()->id)
                        ->where('course_id', $class_id)->get()->Count() > 0)
        {
            $member = ClassMember::where('user_id', auth()->user()->id)->where('course_id', $class_id)->first();
            $member->delete();
        }

        return redirect(route('class.show', $class_id));
    }

    public function showMembers($class_id)
    {
        $users = ClassMember::where('course_id', $class_id)->get();
        $class = Course::findOrFail($class_id);
        $prof = Professor::findOrFail($class->taught_by);
        return view('Classes.members', compact('users', 'class', 'prof'));
    }
}
