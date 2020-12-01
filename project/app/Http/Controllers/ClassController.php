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

    // returns index page
    public function index()
    {
        // get classes user has joined
        $user_joined_classes = ClassMember::select('course_id')->where('user_id', auth()->user()->id)->get();
        $user_classes = array();
        foreach($user_joined_classes as $u=>$val)
        {
            array_push($user_classes, Course::where('id', $val->course_id)->first());
        }

        // if the user is not in a class, redirect to page showing all classes
        if (count($user_classes) <= 0)
        {
            return redirect(route('class.all'));
        }

        // get all professor (used in dropdown when creating a new class)
        $professors = Professor::all();
        return view('Classes.index', compact('professors', 'user_classes'));
    }

    // return allClasses page
    public function allClasses()
    {
        // get all profs (for class creation)
        $professors = Professor::all();
        // get all courses, sort by newest
        $classes = Course::orderBy('created_at')->get();
        return view('Classes.all', compact('classes', 'professors'));
    }

    // get search page
    public function search()
    {
        // empty records as there are no search results yet
        $records = array();
        return view('Classes/classSearch', compact('records'));
    }

    // handle search request
    public function search_post(Request $request)
    {
        // check if search field has content
        if ($request->search == null || $request->search == "")
        {
            // redirect to search page if no content in search
            return redirect(route('class.search'));
        }

        // find all classes that contain search string in name
        $searchString = trim(filter_var($request->search, FILTER_SANITIZE_STRING));
        $records = Course::where('class_name', 'LIKE', "%{$searchString}%")->get();

        // if there are results, return them
        if ($records->count() > 0)
        {
            return view('Classes/classSearch', compact('records'));
        }
        // otherwise redirect to search page
        else
        {
            return redirect(route('class.search'));
        }
    }
    
    // return page that shows as specific class
    public function show($id)
    {
        // get various information associated with the class
        $class = Course::findOrFail($id);
        $prof = Professor::findOrFail($class->taught_by);
        $posts = Post::where('course_id', $class->id)->get();
        $members = ClassMember::where('course_id', $class->id)->get();
        $listings = Listing::where('course_id', $class->id)->where('deleted', false)->where('sold', false)->get();
        $events = ImportantDates::where('course_id', $class->id)->where('due_date', '>=', strtotime('now'))->orderBy('due_date', "ASC")->get();
        return view('Classes.class', compact('class', 'prof', 'posts', 'members', 'listings', 'events'));
    }

    // add a new class to the db
    public function addClass(Request $request)
    {
        // create new course
        $class = new Course();
        // class name will have no spaces and be all caps
        $class->class_name = str_replace(' ', '', strtoupper($request->class_name));
        $class->taught_by = $request->taught_by;
        $class->semester = $request->semester;
        // always use current year
        $class->year = (int)date("Y");
        $class->created_by = auth()->user()->id;
        $class->save();

        // add creator as a class member
        $member = new ClassMember();
        $member->user_id = $class->created_by;
        $member->course_id = $class->id;
        $member->save();

        // go to class index page
        return redirect(route('class.index'));
    }

    // add user as a member to a class
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
        // go to that classes page
        return redirect(route('class.show', $class_id));
    }

    // remove user as a class member
    public function leaveClass($class_id)
    {
        // check if user can leave the class
        if (ClassMember::where('user_id', auth()->user()->id)
                        ->where('course_id', $class_id)->get()->Count() > 0)
        {
            // delete user from class
            $member = ClassMember::where('user_id', auth()->user()->id)->where('course_id', $class_id)->first();
            $member->delete();
        }

        // go to class page
        return redirect(route('class.show', $class_id));
    }

    // returns a page that shows all members for a specific class
    public function showMembers($class_id)
    {
        $users = ClassMember::where('course_id', $class_id)->get();
        $class = Course::findOrFail($class_id);
        $prof = Professor::findOrFail($class->taught_by);
        return view('Classes.members', compact('users', 'class', 'prof'));
    }
}
