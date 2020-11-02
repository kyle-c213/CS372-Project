@extends('Layouts.app')

@section('title')
    {{$title ?? ''}}
@endsection

@if (session('status'))
    <div class="alert alert-success" role="alert">
       {{ session('status') }}                        
    </div>
@endif



@section('content')
    <div class="header">
    {{ __('Dashboard') }}
    </div>
    <div class="text-center top-page">
    <h1>Class name</h1>  <!--Placeholder for class name -->
        <h5 class="text-secondary font-italic">With Prof Name</h5> <!-- place holder for profs name-->
    </div>

    <div class="container" style="position:fixed;left:0">  <!-- Reminders on the right of the page-->
    <div class="row justify-content-left">
        <div class="text-left">
            <div class="card"style="width:200px;height:250px">
                <div class="card-header">{{__('Reminders')}}</div>
                    <div class="card-body">
                        <p>*Reminder 1</p><br>
                        <p>*Reminder 2</p>
                    </div>
            </div>
        </div>
    </div>
</div>


<div class="container">  <!-- Place holder for posts -->
    <div class="row justify-content-center">
            <div class="card" style="width:400px">
                <div class="card-header">{{ __('UserName  Time /date') }}</div> <!-- User name and time of the post -->
                <div class="card-body">
                        <p> Post Content</p>
                    </div>
            </div>
        </div>
    </div>

<br><br>

<div class="container">  <!-- Place holder for posts -->
    <div class="row justify-content-center">
            <div class="card" style="width:400px">
                <div class="card-header">{{ __('UserName  Time /date') }}</div> <!-- User name and time of the post -->
                <div class="card-body">
                        <p> Post Content</p>
                    </div>
            </div>
        </div>
    </div>


        



<div class="fixed-bottom">  <!-- Submit a Post -->
    <div class="row justify-content-center">
        <form>
        <textarea id="Mpost" name ="Mpost" rows="4" cols="50">
            Create Post
            </textarea> 
            <br>
            <a class="btn btn-primary btn-lg" role="button">Post</a> 
            </form>
    </div>
</div>


<br><br><br><br><br><br>
<div class="container" style="position:fixed;bottom:25px">  <!-- Show Users who are in the class -->
    <div class="row justify-content-left">
        <div class="text-center">
            <div class="card"style="width:300px;height:100px">
                <div class="card-header">{{__('Users in the Class')}}</div>
                    <div class="card-body">
                        <p>User1  User2  User3...</p>
                    </div>
            </div>
        </div>
    </div>
</div>


@endsection

<!-- Contacts menu on Right-->
@include('inc.contactsidebar')




