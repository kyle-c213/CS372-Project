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
            'course_id' => '',
            'pic' => 'image',
        ]);
        
        if(request('pic'))
        {
            $picPath = request('pic')->store('uploads', 'public');
            $pic = Image::make(public_path("storage/{$picPath}"))->fit(1000, 1000);
            $pic->save();

            $picArray = ['pic' => $picPath];
        }


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
