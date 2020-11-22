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
/*
     public function create($prof)
    {
       
       $prof = Professor::findOrFail($prof);
       'name' => $prof,
       'faculty' => $prof,
       

       return view('profRate/create');
    }
*/
     public function store($prof)
    {
       /*
        $prof = Professor::findOrFail($prof);
        'name' => $prof,
        'faculty' => $prof,
        */

        return view('profRate/store');
    }
}
