@extends('Layouts.app')

{{-- @section('title')
    {{$title}}
@endsection --}}

<!-- Main body content-->
@section('content')
    <div class="container " id="body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div name="PInfo" class="container">
                    <!--
                        to be displayed:
                        profile pic (if we have them), name, faculty, avg rating
                    -->
                    <div name="information">
                        <h3>Professor Information</h3>
                        <p name="name"> Professors name here<!--{{ $prof->name ?? '' }}--> </p>
                        <p name="faculty"> professors faculty here<!--{{ $prof->faculty  ?? '' }}--> </p>
                        <p name="avgRating"> print prof avg rating here</p> 
                    </div>

                    <!--
                        to be displayed:
                        other user's ratings (name/username, rating & comments)
                        as table with column order -> class rating comment
                    -->
                    <div name="pastRatings">
                        <h3>Current Ratings</h3>

                        <!-- start of php -->
                        <?php
                            //need to change $result and $id to work
                            /*if($result == null){
                                print('<p name="NoResults"> there are currently no ratings for this professor at this time </p>');
                            } else {
                                print('<!--table may need to be reworked todiplay properly-->
                                <table class="table table-striped">
                                    <tr>
                                        <!---display all classes--->
     	                                <th><strong>Class</th>
   	                                    <th><strong>Rating</th>
                                        <th><strong>comments</th>
                                    </tr>
                                    <!--display all ratings for a class-->');
                                    foreach($result as $result => $id){ 
                                        print('<tr>
                                            <td>' + $class + '</td>
                                            <td>' + $Rating + '</td>
                                            <td>' + $comments + '</td>
                                        </tr>');
                                    }
                                print('</table>');
                            }*/
                        ?><!-- end of php -->
                    </div>
                </div>

                <div name="PRate" class="container">
                    <h3>Rate Here</h3>
                    <!--
                        to be gathered:
                        rating, class, comments
                    -->

                    <form name="ratingSub" id="ratingSub" action="store" method="post" enctype="multipart/form-data">
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
