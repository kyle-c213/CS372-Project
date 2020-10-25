@extends('layouts.app')

@section('title')
    {{$title}}
@endsection

<!--Left Sidebar-->
@include('inc.sidebar')

@section('content')
    <div name="PInfo" class="container">
        <!--
            to be displayed:
            profile pic (if we have them), name, faculty, avg rating
            other user's ratings (name/username, rating & comments)
        -->
    </div>
    <div name="PRate" class="container">
        <h5>Rate here</h5>
        <!--
            to be gathered:
            rating, class, comments
        -->
    </div>
@endsection
<!-- Contacts menu on Right-->
@include('inc.contactsidebar')
