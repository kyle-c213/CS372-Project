@extends('Layouts.app')

<!-- Main body content-->
@section('content')
    <div class="container " id="body">
        <div class="row justify-content-center">
            <div class="col-md-8">
            <!--remove, just put form to get new rating here-->
                <div name="PRate" class="container">
                    <h3>Rate Here</h3>
                    <form name="ratingSub" id="ratingSub" action="store" method="post" enctype="multipart/form-data">
                        @csrf <!--verification that its from the rating page-->
                        <p> What class would you like to submit a rating for: <input type="text" name="classRated" id="classRated">
                        <p> What rating would you like to submit: <input type="text" name="rated" id="rated">
                        <textarea id="comments" name="comments"rows="10" cols="50" placeholder="Add comments here"></textarea>
                        <p><input type="submit" value="Add Rating"></p>
                    </form>
                <div>
            <!--end of remove-->   
            </div>
        </div>
    </div>
@endsection
