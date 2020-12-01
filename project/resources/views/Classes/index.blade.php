@extends('layouts.app')

<link href='chosen/chosen.min.css' rel='stylesheet' type='text/css'>
<script src='chosen/chosen.jquery.min.js' type='text/javascript'></script>


@section('content')

<h1>Your Classes</h1> <a href='#' data-toggle="modal" data-target="#createClass"><span class="fas fa-pen"></span> Create Class</a>
<hr/>

@if (count($user_classes) <= 0)
    <h4>No classes exist yet. <a href='#' data-toggle="modal" data-target="#createClass">Create a new one!</a></h4>
@endif

@foreach($user_classes as $c=>$val)
    <div class="card">
        <div class="card-body">
            <a href="{{route('class.show', $val->id)}}"><h3>{{$val->class_name}}</h3></a>
            <span>Professor: <a href="{{route('profRate.show', $val->taught_by)}}">{{\App\Models\Professor::where('id', $val->taught_by)->first()->name}}</a></span>
            <br/>
            <span>Semester: {{$val->semester}} {{$val->year}}</span>
            <br/>
            <span>Members: {{\App\Models\ClassMember::where('course_id', $val->id)->count()}}</span>
        </div>
    </div>
    <br>
@endforeach

@if (count($user_classes) > 0)
    <a href="{{route('class.all')}}">View all classes</a>
@endif




<!-- Modal to create a new class -->
<div class="modal fade" id="createClass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Create a class</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <form action="{{route('class.add')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="class_name" id="class_name" class="form-control" placeholder="Class name"/>
                    </div>
                    <div class="form-group">
                        <select name="taught_by" id="taught_by" class="form-control">
                            <option val="">Select a professor</option>
                            @foreach($professors as $p)
                                <option value="{{$p->id}}">{{$p->name}} (Faculty of {{$p->faculty}})</option>
                            @endforeach
                        </select>
                        <span>Can't find your professor? </span><a href="{{route('profSearch.create')}}">Add them here!</a>
                    </div>
                    <div class="form-group">
                        <?php $year = date("Y"); ?>
                        <select name="semester" id="semester" class="form-control">
                            <option val="">Select a semester</option>
                            <option val="fall">Fall</option>
                            <option val="winter">Winter</option>
                            <option val="summer">Summer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Create!"/>
                    </div>
                </form>
            </div>
      </div>
    </div>
</div>

@endsection