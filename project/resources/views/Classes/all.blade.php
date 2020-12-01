@extends('layouts.app')

@section('content')

<h1>All Classes</h1>
<a href='#' data-toggle="modal" data-target="#createClass"><span class="fas fa-pen"></span> Create Class</a>
<br>
<a href="{{route('class.search')}}"><span class="fas fa-search"></span> Search for a class</a>
<hr/>

@forelse($classes as $c=>$val)

<div class="card">
    <div class="card-body">
        <a href="{{route('class.show', $val->id)}}"><h3>{{$val->class_name}}</h3></a>
        <!-- check if user is a member -->
        @if (\App\Models\ClassMember::where('course_id', $val->id)->where('user_id', auth()->user()->id)->count() > 0)
            <b class="text-danger">You are a member of this class</b><br/>
        @endif
        <span>Professor: <a href="{{route('profRate.show', $val->taught_by)}}">{{\App\Models\Professor::where('id', $val->taught_by)->first()->name}}</a></span>
        <br/>
        <span>Semester: {{$val->semester}} {{$val->year}}</span>
        <br/>
        <span>Members: {{\App\Models\ClassMember::where('course_id', $val->id)->count()}}</span>
    </div>
</div>
<br>
@empty
<h6>No classes have been created!</h6>
@endforelse


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