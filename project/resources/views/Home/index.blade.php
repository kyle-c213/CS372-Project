@extends('Layouts.app')

@section('title')
    {{$title}}
@endsection

<!--Left Sidebar-->
@include('inc.sidebar')

<!-- Main body -->
@section('content')
    <div class="container" id="body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-index">
                    <div class="card-header">
                        <h4>Make a Post</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <textarea name="body" cols="40" rows="5" class="form-control"></textarea>
                            <label for="Classes">Choose a Class</label>
                            <select id="Classes" name="Classes">
                                <option value="All">All</option>
                                <option value="CS372">CS372</option>
                                <option value="CS340">CS340</option>
                                <option value="Placeholders...">Placeholders...</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-right">Share</button>
                        </form>
                    </div>   
                
                    <div class="card-header">
                        <h4>Updates from your classes</h4>
                    </div>
                    <div class="card-body">

                        Content...
                        
                    </div>
                </div>
            </div>       
        </div>
    </div>
@endsection

<!-- Contacts menu on Right-->
@include('inc.contactsidebar')