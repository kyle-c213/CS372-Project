<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use \App\Models\Professor;

class ProfRateController extends Controller
{

    public function search()
    {

        return view('profRate/search');
    }
    
     public function rate($prof)
    {
       /*
        $prof = Professor::findOrFail($prof);
        'name' => $prof,
        'faculty' => $prof,
        */

        return view('profRate/rate');
    }
}
