<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

    public function __construct() 
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }


    public function create()
    {
        return view('comments.create');
    }

    public function store()
    {
        //store comments
        $post = Post::findOrFail(request('post_id'));

        //create comment
        Comment::create(['body' => request('bodyComment'),
                        'user_id' => Auth::id(),
                        'post_id' => $post->id
        ]);

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        if(isset($request->commentID))
        {
            $comment = Comment::findOrFail($request->commentID);
            $comment->delete();
        }
    }
}
