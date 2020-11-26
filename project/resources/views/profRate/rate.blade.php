@extends('Layouts.app')

{{-- @section('title')
    {{$title}}
@endsection --}}

<script>
    function searchProf()
    {
        // $("#resultsList").empty();

        var searchString = $prof->id;
        var url = "{{route('profSearch.search2')}}";

        jQuery.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'POST',
            data: jQuery.param({
                searchString: searchString
            }),
            dataType: 'JSON',
            cache: false,
            processData: false,      
            success: function(data){
                if (data.emptyList == true)
                {
                   // the list that holds results
                    var ul = document.getElementById("avgRating").innerHTML = 'No ratings yet';
                }
                else
                {
                    // the list that holds results
                    var ul = document.getElementById("avgRating")innerHTML = 'avg rating here';
                }
            },
            error: function()
            {
            }
        });
    }
</script>

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
                        <p name="name"style="display:inline-block;"><b> Name:</b> {{ $prof->name ?? 'Missing' }} </p>
                        <p name="spacing" style="display:inline-block;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
                        <p name="faculty"style="display:inline-block;"><b>Faculty:</b> {{ $prof->faculty  ?? 'Unkown/Error' }} </p>
                        <p name="avgRating"> <b>Average Rating: </b><p id='avgRating'></p></p> 
                    </div>
                    <br>
                    <div name="CurrentRatingsList">
                        <h3>Current Ratings</h3>

                        <div class="searchResults">
                            <ul id="resultsList" class="nav flex-column">
                            </ul>
                        </div>
                        <ul class="nav flex-column" id="RatingsList">
                            <?php
                                $ratings = \App\Models\Rating::where('professor_rated', $prof->id)->get();
                                $hasRatings = false;
                            ?>
                            @foreach($ratings as $key=>$val)
                                <?php
                                    $hasRatings = true;
                                    $rating = \App\Models\Rating::where('id', $val->second_user)->first()->name;
                                ?>
                                <!--<li class="p-1">
                                        who rating comment
                                    </li>-->
                            @endforeach
                            @if($hasRatings == false)
                                <li id="noRatingsMessage">
                                    <b>This professor has no ratings yet!</b>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <br>
                <div name="PRate" class="container">
                    <h3>Rate Here</h3>
                    <!--
                        to be gathered in the form:
                            rating, class, comments
                        gathered but not entered:
                            prof id, user id
                    -->
                    <form name="ratingSub" id="ratingSub" action="store" method="post" enctype="multipart/form-data">
                        <!--<input type='hidden' id='rated_by' name='rated_by' value='{{$user->id ?? ''}}'>-->
                        <input type='hidden' id='professor_rated' name='professor_rated' value='{{$prof->id}}'>
                        <p> What class would you like to submit a rating for: <input type="text" name="class_taken" id="class_taken"></p>
                        <p> What rating would you like to submit: <input type="text" name="rating" id="rating"></p>
                        <textarea id="comments" rows="10" cols="50" placeholder="Add comments here"></textarea>
                        <p><input type="submit" value="Add Rating"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
