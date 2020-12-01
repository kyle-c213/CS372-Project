@extends('layouts.app')

@section('content')

        <h1>Event Details</h1>
        <hr/>
        <dl>
            <dt>Event Name</dt>
            <dd>{{$event->title}}</dd>
            <dt>Date</dt>
            <dd>{{$event->due_date->format('F j, Y')}}</dd>
            <dt>Class</dt>
            <dd><a href="{{route('class.show', $event->course_id)}}">{{\App\Models\Course::where('id', $event->course_id)->first()->class_name}}</a></dd>
            <dt>Created By</dt>   
            <dd><a href="{{ route('profile.show', $event->user_id) }}">{{\App\Models\User::where('id', $event->user_id)->first()->name}}</a></dd>
        </dl>
        <b>Description</b>
        @if($event->body != null)
            <p>{{$event->body}}</p>
        @else
            <p>No event description found</p>
        @endif

@endsection