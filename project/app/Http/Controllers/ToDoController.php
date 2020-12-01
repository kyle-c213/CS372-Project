<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToDo;

class ToDoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        // current user
        $user = auth()->user();
        // gets todos that belong to current user
        $todo = ToDo::where('user_id', $user->id)
            ->where('complete', false)
            ->where('deleted', false)
            ->orderBy('due_date', 'asc')->get();
        // $todo is passed as the model and can be accessed in the view
        //      user is passed to view as well
        return view("ToDo.index", compact('todo'))->with('user', $user);
    }

    // add task post function
    // receiving parameters body and dateTime
    public function addTask(Request $request)
    {
        // creates new instance of todo & assigns values passed through ajax call
        $todo = new ToDo();
        $todo->body = $request->body;
        $todo->due_date = $request->dateTime;
        // current user
        $todo->user_id = auth()->user()->id;
        $todo->complete = false;
        $todo->deleted = false;
        // save instance to db
        $todo->save();

        // format the date
        $date = $todo->due_date->format('F d, Y');

        return ['id' => $todo->id, 'date' => $date];
    }

    // mark task as complete
    public function completeTask(Request $request)
    {
        $todo = ToDo::findOrFail($request->id);
        $todo->complete = true;
        $todo->save();
    }

    // update the body
    public function updateBody(Request $request)
    {
        $todo = ToDo::findOrFail($request->id);
        $todo->body = $request->body;
        $todo->save();
    }

    // update the date
    public function updateDate(Request $request)
    {
        $todo = ToDo::findOrFail($request->id);
        $todo->due_date = $request->date;
        $todo->save();
    }
}
