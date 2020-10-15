@extends('Layouts.app')

@section('title')
    {{$title ?? ''}}
@endsection

@section('content')
    <div class="text-center middle-page">
        <h1>Welcome to Student Zone!</h1>
        <h5 class="text-secondary font-italic">Connect with classmates, sell textbooks and more!</h5>
        <p>
            <a class="btn btn-primary btn-lg" href="{{url('Home/login')}}" role="button">Login</a>
            <a class="btn btn-primary btn-lg" href="{{url('Home/signup')}}" role="button">Signup</a>
        </p>
    </div>
@endsection
