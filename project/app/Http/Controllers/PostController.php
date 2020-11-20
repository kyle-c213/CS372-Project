<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        //validate data passed in request
        $data = request()->validate([
            'title' => 'required',
            'body' => 'required',
            //***IMPLEMENT CLASS THEN UNCOMMENT***
            // 'classSelect' => '',
            'file' => 'image',
        ]);
        
        if(request()->hasFile('file'))
        {
            $filePath = request('file')->store('uploads', 'public');
        }

        //***IMPLEMENT CLASS THEN UNCOMMENT***
        /*
        //find what user chose for which class to put post in
        $class = request()->query('classSelect', 'All');
        //if all classes selected
        if($class == 'All')
        {
            //loop through all courses with the course_id starting at 0
            for($i = 0; $i <= Course::count(); $i++)
            {
                $data['course_id'] = $i;
                //create post in the class
                auth()->user()->posts()->create(array_merge($data, $filePath ?? []));
            }   
        }
        //find the certain class' id
        else
        {
            for($i = 0; $i <= Courses::count(); $i++)
            {
                if($class == $post()->$course()->course_name)
                {
                    $found = true;
                    $data['course_id'] = $i;
                    //create post in the class
                    auth()->user()->posts()->create(array_merge($data, $filePath ?? []));
                    break;
                }
            }

            if(!$found)
                echo("Class not found! Post not created!");
        }
        */

        auth()->user()->posts()->create(array_merge($data, $filePath ?? []));
        return redirect('profile/' . auth()->user()->id);
    }

    public function destroy($post_id)
    {
        $post = Post::find($post_id);
        $post->delete();
        return redirect('profile/' . auth()->user()->id);
    }
}
