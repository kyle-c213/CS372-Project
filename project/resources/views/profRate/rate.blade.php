@extends('Layouts.app')

{{-- @section('title')
    {{$title}}
@endsection --}}

<!--Left Sidebar-->
@include('inc.sidebar')

<!-- Main body content-->
@section('content')
    <div class="container" id="body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div name="PInfo" class="container">
                    <!--
                        to be displayed:
                        profile pic (if we have them), name, faculty, avg rating
                    -->
                    <div name="information">
                        <h3>Professor Information</h3>
                        <p name="name"> print prof name here</p>
                        <p name="faculty"> print faculty here </p>
                        <p name="avgRating"> print prof avg rating here</p> 
                    </div>

                    <!--
                        to be displayed:
                        other user's ratings (name/username, rating & comments)
                        as table with column order -> class rating comment
                    -->
                    <div name="pastRatings">
                        <h3>Professor's current ratings</h3>
                        if($result == null){
                            <p name="NoResults"> there are currently no ratings for this professor at this time </p>
                        } else {
                        <!--table may need to be reworked todiplay properly-->
                            <table class="table table-striped">
                                <tr>
                                <!--display all classes-->
                                    <th><strong>Class</th>
                                    foreach($result as $result => $class){
                                        <td>$class</td>
                                    }
                                </tr>
                                <tr>
                                <!--display all ratings for a class-->
                                    <th><strong>Rating</th>
                                    foreach($result as $result => $Rating){
                                        <td>$Rating</td>
                                    }
                                </tr>
                                <tr>
                                <!--display all comments for the rating-->
                                    <th><strong>comments</th>
                                    foreach($result as $result => comments){
                                        <td>comments</td>
                                    }
                                </tr>
                            </table>
                        } 
                    </div>
                </div>

                <div name="PRate" class="container">
                    <h5>Rate here</h5>
                    <!--
                        to be gathered:
                        rating, class, comments
                    -->

                    <form name="ratingSub" id="ratingSub" action="" method="" enctype="multipart/form-data">
                        <p> What class would you like to submit a rating for: <input type="text" name="classRate" id="classRate"></p><p class="error" name="classError" id="classError"></p>
                        <p> What rating would you like to submit: <input type="text" name="ratedRate" id="ratedRate"></p><p class="error" name="ratedError" id="ratedError"></p>
                        <P class="error" id="textError"></P>
                        <textarea id="txtBox" rows="10" cols="50" placeholder="Add comments here"></textarea>
                        <p><input type="submit" value="Add Rating"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Contacts menu on Right-->
@include('inc.contactsidebar')
