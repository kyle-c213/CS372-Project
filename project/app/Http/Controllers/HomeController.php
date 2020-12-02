<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use \App\Models\Course;
use App\Models\ClassMember;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // get classes user has joined
        $user_joined_classes = ClassMember::select('course_id')->where('user_id', auth()->user()->id)->get();
        $classes = array();
        $posts = array();
        $class_posts = array();
        foreach($user_joined_classes as $u=>$val)
        {
            $class_posts = Post::where('course_id', $val->course_id)->get();
            foreach($class_posts as $c=>$post)
            {
                array_push($posts, $class_posts->first());
            }
            array_push($classes, Course::where('id', $val->course_id)->first());
        }

        return view('home', compact('classes', 'posts'));
    }
}
