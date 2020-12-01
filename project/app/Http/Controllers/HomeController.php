<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use \App\Models\Course;

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
        $classes = Course::all();
        $posts = Post::orderBy('updated_at', 'desc')->get();
        return view('home', compact('classes', 'posts'));
    }
}
