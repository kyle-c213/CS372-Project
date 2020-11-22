<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use \App\Models\Rating;

class RatingController extends Controller
{

    public function create()
    {

        return view('profRate/create');
    }
}
