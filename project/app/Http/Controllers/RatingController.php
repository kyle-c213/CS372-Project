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

    /*public function create()
    {
        return view('profRate.create');
    }*/

    /*public function create(array $data)
    {
        return Rating::create([
            'rating' => $data['rating'],
            'rated_by' => $data['rated_by'],
            'professor_rated' => $data['professor_rated'],
            'comments' => $data['comments'],
            'class_taken' => $data['class_taken'],
        ]);
    }*/

    public function store(request $request){

        //data validation from form for ratings
        $data = request()->validate([
            'comments' => ['required', 'string'],
            'rating' => ['required', 'between:1,5', 'integer'],
            'class_taken' => ['required', 'string'],
            'rated_by' => ['required', 'integer'],
            'professor_rated' => ['required', 'integer'],
        ]);


        $rating = new Rating(); //makes new rating element
        $rating->comments = $request->comments; //adds comments from the rating
        $rating->rating = $request->rating; //adds the rating
        $rating->class_taken = $request->class_taken; //adds the class being rated
        $rating->rated_by = $request->rated_by;//adds the users id
        $rating->professor_rated = $request->professor_rated;//adds the profs id
        $rating->save(); //saves the rating to the database
 
        return route('profRate.search'); //redirect to rate Professor
    }
}
