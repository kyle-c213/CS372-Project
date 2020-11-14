@extends('Layouts.app')

{{-- @section('title')
    {{$title}}
@endsection --}}

<!--Left Sidebar-->
@include('inc.sidebar')

<!--Main body content-->
@section('content')
    <div class="container" id="body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div name="PSearch" class="container">
                    <form name="profSearch" id="profSearch" action="search.blade.php" method="POST">
                        <h5>Search a Professor to Rate</h5><br>
                        <input type="hidden" name="submitted" id="submitted" value="1">
                        <input type="text" name="Psearchbar" id="Psearchbar" placeholder="Search for a professor here" style=" width: 200px;">
                        <input type="submit" value="Search" style="width: 70px;">
                    </form>
                </div>
                <div name="PResult" class="container">
                    <h5>Current Results</h5>
                    <!--list of all profs to start, once searched list is reduced, says not profs found-->
        
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Contacts menu on Right-->
@include('inc.contactsidebar')
