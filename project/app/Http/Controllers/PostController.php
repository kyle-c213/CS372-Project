<?php

namespace App\Http\Controllers;

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
            'file' => 'image',
        ]);
        
        if(request('file'))
        {
            $filePath = request('file')->store('uploads', 'public');
            $file = Image::make(public_path("storage/{$filePath}"))->fit(1000, 1000);
            $file->save();

            $fileArray = ['file' => $filePath];
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

        auth()->user()->posts()->create(array_merge($data, $fileArray ?? []));
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

    public function editPost(Request $request)
    {
        //validate data passed in request
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        $post = Post::find($request['postID']);
        $post->title = $request['title'];
        $post->body = $request['body'];
        $post->update();

        return response()->json(['new_body' => $post->body, 'new_title' => $post->title], 200);
    }
}
