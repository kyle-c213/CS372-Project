@extends('Layouts.app')

@section('title')
    {{$title}}
@endsection

@section('content')
    @include('inc.error_messages')
    {!! Form::open(['url' => 'Home/post_signup']) !!}
        <div class="form-group container">
            {{Form::label('email','Email')}}
            {{Form::email('email','', ['class' => 'form-control col-sm-2'])}}
            {{Form::label('password','Password')}}
            {{Form::password('password', ['class' => 'form-control col-sm-2'])}}
            {{Form::label('verifypassword','Verify Password')}}
            {{Form::password('verifypassword', ['class' => 'form-control col-sm-2'])}}
        </div>
        <div class="form-group container">
            {{Form::submit('Sign Up!', ['class' => 'btn btn-primary'])}}
        </div>
    {!! Form::close() !!}
@endsection