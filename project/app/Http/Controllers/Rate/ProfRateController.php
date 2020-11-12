<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use \App\Models\Professor;

class ProfRateController extends Controller
{

    public function search()
    {
        return view('search');
    }
    
     public function rate($prof_id)
    {
        return view('rate');
    }
}
