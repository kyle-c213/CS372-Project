<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use Image;

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
            'pic' => 'image',
        ]);
        
        if(request('pic'))
        {
            $picPath = request('pic')->store('uploads', 'public');
            $pic = Image::make(public_path("storage/{$picPath}"))->fit(1000, 1000);
            $pic->save();

            $picArray = ['pic' => $picPath];
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
                auth()->user()->posts()->create(array_merge($data, $picPath ?? []));
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
                    auth()->user()->posts()->create(array_merge($data, $picPath ?? []));
                    break;
                }
            }

            if(!$found)
                echo("Class not found! Post not created!");
        }
        */

        auth()->user()->posts()->create(array_merge($data, $picArray ?? []));
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        if(isset($request->postID))
        {
            $post = Post::findOrFail($request->postID);
            $post->delete();
        }
    }

    public function editPost()
    {
        $post = Post::findOrFail(request('editPID'));
        
        if($post->user->id == auth()->user()->id)
        {
            //validate data passed in request
            $data = request()->validate([
                'editTitle' => 'required',
                'editBody' => 'required',
                //***IMPLEMENT CLASS THEN UNCOMMENT***
                // 'classSelect' => '',
                'editPic' => 'image',
            ]);

            //check for file
            if(request('editPic'))
            {
                $picPath = request('editPic')->store('uploads', 'public');
                $pic = Image::make(public_path("storage/{$picPath}"))->fit(1000, 1000);
                $pic->save();

                $post->pic = $picPath;
            }

            //update post
            $post->title = request('editTitle');
            $post->body = request('editBody');
            $post->update();
        }

        return redirect()->back();
    }
}
