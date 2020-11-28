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

    public function store(request $request){

        //data validation from form for ratings
        $data = request()->validate([
            'comments' => ['required', 'string'],
            'rating' => ['required','between:1,5', 'integer'],
            'course_taken' => ['required', 'integer'],
            'rated_by' => ['required', 'integer'],
            'professor_rated' => ['required', 'integer'],
        ]);
        

        $rating = new Rating(); //makes new rating element
        $rating->body = $request->comments;//adds comments from the rating
        $rating->rating = $request->rating; //adds the rating
        $rating->course_taken = $request->class_taken; //adds the class being rated
        $rating->rated_by = auth()->user()->id;//adds the users id
        $rating->professor_rated = $request->professor_rated;//adds the profs id
        $rating->save(); //saves the rating to the database

        return redirect(route('profRate.show', $request->professor_rated)); //redirect to rate Professor
    }
}
