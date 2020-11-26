@extends('Layouts.app')

<!-- Main body content-->
@section('content')
        <div class="row justify-content-center">
            <div class="col-md-8">
            <!--form to add new Professor-->
                <div name="PRate" class="container">
                    <h3>Rate Here</h3>
                    <form name="ratingSub" id="ratingSub" action="store" method="post" enctype="multipart/form-data">
                        @csrf <!--verification that its from the rating page-->
                        <h5>You will be sent to the new professor's rating page once filled out</h5>
                        <p> Professor Name: <input type="text" name="name" id="name">
                        <p> Profssor Faculty: <input type="text" name="faculty" id="faculty">
                        <p><input type="submit" value="Add Professor"></p>
                    </form>
                <div>
            <!--end of form-->   
            </div>
        </div>
@endsection
