@extends('layouts.app')

@section('content')

<!-- Search Form -->
<form action="{{route('class.search_post')}}" method="POST">
    @csrf
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Seach for a class" name="search"/>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Search"/>
    </div>
</form>

<!-- Search results -->
@forelse($records as $r)
<div class="card">
    <div class="card-body">
        <a href="{{route('class.show', $r->id)}}"><h3>{{$r->class_name}}</h3></a>
        <span>Professor: <a href="{{route('profRate.show', $r->taught_by)}}">{{\App\Models\Professor::where('id', $r->taught_by)->first()->name}}</a></span>
        <br/>
        <span>Semester: {{$r->semester}} {{$r->year}}</span>
        <br/>
        <span>Members: {{\App\Models\ClassMember::where('course_id', $r->id)->count()}}</span>
    </div>
</div>
<br>
@empty
    <p>Search results will be displayed here!</p>
@endforelse

@endsection