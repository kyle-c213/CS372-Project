<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use \App\Models\Rating;

class RatingController extends Controller
{
    //requires the user to be signed in to do any thing related to ratings
    public function __constructor(){
        $this->midddleware('auth');
    }

    public function create()
    {

        return view('profRate/create');
    }

    public function store(){

        //data validation from form for ratings
        $data = request()->validate([
            'comments' => ['required', 'string'],
            'rating' => ['required', 'between:1,5', 'numeric'],
            'classRated' => ['required', 'string'],
            //user id still needed
            //professor id still needed
        ]);


        auth()->user()->ratings()->create([
            'comments' => $data['comments'],
            'rating' => $data['rating'],
            'classRated' => $data['classRated'],
            //user id still needed
            //professor id still needed
        ]);

        \App\Models\Rating::create($data)

        return redirect(view('profRate/rate'));
    }
}
