@extends('layouts.app')

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
                <div name="PInfo" class="container">
                    <!--
                        to be displayed:
                        profile pic (if we have them), name, faculty, avg rating
                    -->
                    <h1 name="name">{{ $prof->name ?? 'Missing' }}</h1>
                    <h5 name="faculty" class="text-secondary">{{ $prof->faculty  ?? 'Unkown/Error' }} </h5>
                    <p name="avgRating"> <b>Average Rating: </b><p id='avgRating'></p></p> 
                    <hr/>
                    <div name="CurrentRatingsList" class="card">
                        <div class="card-header">
                            <h3>Ratings</h3>
                        </div>

                        {{-- <div class="searchResults">
                            <ul id="resultsList" class="nav flex-column">
                            </ul>
                        </div> --}}

                        <div class="card-body">
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
                </div>
                <br>
                <div name="PRate" class="card py-4 px-4">
                    <h3>Rate Here</h3>
                    <!--
                        to be gathered in the form:
                            rating, class, comments
                        gathered but not entered:
                            prof id, user id
                    -->
                    <form name="ratingSub" id="ratingSub" action="store" method="post" enctype="multipart/form-data">
                        <!--<input type='hidden' id='rated_by' name='rated_by' value='{{$user->id ?? ''}}'>-->
                        <input type='hidden' id='professor_rated' name='professor_rated' value='{{$prof->id}}' class="form-control" />
                        <p> What class would you like to submit a rating for: <input type="text" name="class_taken" id="class_taken" class="form-control"></p>
                        <p> What rating would you like to submit: <input type="text" name="rating" id="rating" class="form-control"></p>
                        <textarea id="comments" style="height:150;" placeholder="Add comments here" class="form-control"></textarea>
                        <br/>
                        <p><input type="submit" value="Add Rating" class="btn btn-primary"></p>
                    </form>
                </div>
    </div>
@endsection
