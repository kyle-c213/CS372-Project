@extends('Layouts.app')

@section('title')
    {{$title ?? ''}}
@endsection

@section('content')
    <div class="text-center">
        <h1>Welcome!</h1>
        <p>
            <a class="btn btn-primary btn-lg" href="{{url('Home/login')}}" role="button">Login</a>
            <a class="btn btn-primary btn-lg" href="{{url('Home/signup')}}" role="button">Signup</a>
        </p>
    </div>
@endsection