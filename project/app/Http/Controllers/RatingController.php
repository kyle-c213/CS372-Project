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

    public function create(array $data)
    {
        return Rating::create([
            'rating' => $data['rating'],
            'rated_by' => $data['rated_by'],
            'professor_rated' => $data['professor_rated'],
            'comments' => $data['comments'],
            'class_taken' => $data['class_taken'],
        ]);
    }

    public function store(){

        //data validation from form for ratings
        $data = request()->validate([
            'comments' => ['required', 'string'],
            'rating' => ['required', 'between:1,5', 'integer'],
            'class_taken' => ['required', 'string'],
            'rated_by' => ['required', 'integer'],
            'professor_rated' => ['required', 'integer'],
        ]);


        auth()->user()->ratings()->create([
            'comments' => $data['comments'],
            'rating' => $data['rating'],
            'class_taken' => $data['class_taken'],
            'rated_by' => $data['rated_by'],
            'professor_rated' => $data['professor_rated'],
        ]);

        \App\Models\Rating::create($data);

        return redirect(view('profRate/rate'));
    }
}
