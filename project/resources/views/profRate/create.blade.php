@extends('layouts.app')

<!-- Main body content-->
@section('content')
<!--form to add new Professor-->
    <div name="PRate" class="card">
        <div class="card-header">
            <h3>Add A New Professor</h3>
        </div>
        <div class="card-body">
            <form name="ratingSub" id="ratingSub" action="store" method="post" enctype="multipart/form-data">
                @csrf <!--verification that its from the rating page-->
                <p> Professor Name: <input type="text" name="name" id="name" class="form-control col-md-6"/>
                <p> Professor Faculty: <input type="text" name="faculty" id="faculty" class="form-control col-md-6">
                <p><input type="submit" value="Add Professor" class="btn btn-primary"></p>
            </form>
        </div>
    </div>
<!--end of form--> 
@endsection
