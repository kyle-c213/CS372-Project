<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //GET index
    public function index(){
        $title = "Home";
        return view('Home.index')->with('title', $title); // could be -- return view('Home.index', compact('title'));
    }

    // GET login
    public function login(){
        $title = "Login";
        return view('Home.login')->with('title', $title);
    }

    public function post_login(Request $request){
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        // 

        return view('Home.index')->with('title', 'Home');
    }

    // GET signup
    public function signup(){
        $title = 'Signup';
        return view('Home.signup')->with('title', $title);
    }

    // POST signup  
    public function post_signup(Request $request){
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
            'verifypassword' => 'required'
        ]);

        // add user to db
            

        return view('Home.index')->with('title', 'Home');
    }
}
