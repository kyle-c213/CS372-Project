@extends('layouts.app')

@section('title')
    {{$title}}
@endsection

<!--Left Sidebar-->
@include('inc.sidebar')

@section('content')
    <div name="CSearch" class="container">
        <form name="ClassSearch" id="ClassSearch" action="classSearch.blade.php" method="POST">
            <h5>Search for class</h5><br>
            <input type="hidden" name="submitted" id="submitted" value="1">
            <input type="number" name="Csearchbar" id="Csearchbar" placeholder="Search for Class">
            <input type="submit" value="Search" style="width: 70px;">
        </form>
    </div>
    <div name="CResult" class="container">
        <h5>Current Results</h5>
        <!--list of all classes-->
    </div>
@endsection
<!-- Contacts menu on Right-->
@include('inc.contactsidebar')