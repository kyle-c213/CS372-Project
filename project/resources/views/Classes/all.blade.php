@extends('layouts.app')

@section('content')

<h1>All Classes</h1>
<a href='#' data-toggle="modal" data-target="#createClass"><span class="fas fa-pen"></span> Create Class</a>
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

@endsection