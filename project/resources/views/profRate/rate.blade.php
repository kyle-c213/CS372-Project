@extends('layouts.app')

<style>

    .selected_star{
        color:orange;
        outline: black 2px;
        
    }

    .star:hover{
        color:rgb(187, 122, 1);
        cursor: pointer;
    }
</style>

<script>
    function updateRating(event)
    {
        var star = event.currentTarget;

        var star1 = document.getElementById("star1");
        var star2 = document.getElementById("star2");
        var star3 = document.getElementById("star3");
        var star4 = document.getElementById("star4");
        var star5 = document.getElementById("star5");
        var rating = document.getElementById("rating");

        // clear all selected star classes to prevent doubling up
        star1.classList.remove("selected_star");
        star2.classList.remove("selected_star");
        star3.classList.remove("selected_star");
        star4.classList.remove("selected_star");
        star5.classList.remove("selected_star");

        switch(star.id)
        {
            case "star1":
                star1.classList.add("selected_star");
                rating.value = 1;
                break;
            case "star2":
                star1.classList.add("selected_star");
                star2.classList.add("selected_star");
                rating.value = 2;
                break;
            case "star3":
                star1.classList.add("selected_star");
                star2.classList.add("selected_star");
                star3.classList.add("selected_star");
                rating.value = 3;
                break;
            case "star4":
                star1.classList.add("selected_star");
                star2.classList.add("selected_star");
                star3.classList.add("selected_star");
                star4.classList.add("selected_star");
                rating.value = 4;
                break;
            case "star5":
                star1.classList.add("selected_star");
                star2.classList.add("selected_star");
                star3.classList.add("selected_star");
                star4.classList.add("selected_star");
                star5.classList.add("selected_star");
                rating.value = 5;
                break;
        }
    }

    function check(event){

        var rate = document.getElementById("rating").value;
        var count =0;

        //checks that a rating is selected
        if(rate == "" || rate == null) {
            errorAlert = document.getElementById("rateError");
            errorAlert.innerHTML = "please select a rating";
            errorCount++;
            event.preventDefault();
        } else {
            errorAlert = document.getElementById("rateError");
            errorAlert.innerHTML = "";
        }

        return;
    }
</script>

<!-- Main body content-->
@section('content')
    <div class="container " id="body">
                <div name="PInfo" class="container" onload:'AvgRating()'>
                    <!--
                        to be displayed:
                        profile pic (if we have them), name, faculty, avg rating
                    -->
                    <h1 name="name">{{ $prof->name ?? 'Missing' }}</h1>
                    <h5 name="faculty" class="text-secondary">{{ $prof->faculty  ?? 'Unkown/Error' }} </h5>
                    <h4 id='avgRating' step='0.01'>
                    @if ($avgRate == -1)
                        <!-- the list that holds results -->No ratings yet
                    @else
                        <!--the list that holds results-->{{$avgRate}}
                    @endif
                    </h4>
                    <a href='#' data-toggle="modal" data-target="#createRating"><span class="fas fa-pen"></span> Add A Rating</a>
                    <hr/>
                    <div class="card">
                        <div class="card-header">
                            <h4>Current Ratings</h4>
                        </div> 
                        <div class="card-body">
                        <!-- No Posts to show -->
                        @if($records->count() == 0)
                            <div class="d-flex justify-content-center">
                                <h3><strong>This professor has no ratings yet!</strong></h3>
                            </div>
                        @endif 

                        <?php $count=0; ?>
                        @foreach($records as $r=>$record)
                        <?php $count++; ?>
                            <!-- Head of post, includes posters name, date posted, etc... -->
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center edit">
                                        <img src="{{ asset('/storage/'.config('chatify.user_avatar.folder').'/'. \App\Models\User::where('id', $record->rated_by)->first()->avatar) }}"
                                            alt="pic" class="rounded-circle" style="max-width: 35px;">
                                        <h5 class="pl-2 pt-1"><a href="{{ route('profile.show', $record->rated_by) }}" style="color:black;"><strong>{{ \App\Models\User::where('id', $record->rated_by)->first()->name }}</strong></a></h5>
                                    </div>
                                    <div class="d-flex justify-content-between delete"  data-postid="{{ $record->id }}">
                                        <div>
                                            <table class="small pl-1 pt-1 text-muted">
                                                <tr>
                                                    <td class="pr-2">Created at: {{ $record->created_at->format('h:ia \\o\\n F d') }}</td>
                                                    @if($record->created_at != $record->updated_at)
                                                        <td style="border-left:1px solid #ccc;" class="pl-2">Updated at: {{ $record->updated_at->format('h:ia \\o\\n F d') }}</td>
                                                    @endif
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!--  Content of post  -->   
                                <div class="card-body" data-postid="{{ $record->id }}" data-count="{{ $count }}">
                                    <h3>
                                        @for($i = 0; $i < 5; $i++)
                                            @if ($i < $record->rating)
                                                <span class="fas fa-star selected_star"></span>
                                            @else
                                                <span class="fas fa-star"></span>
                                            @endif
                                        @endfor
                                    </h3>
                                    <hr style="border-top: 1px solid #D3D3D3; margin-top: -5px;" >
                                    <div class="d-flex justify-content-between">
                                        <p class="pt-1">
                                            {{ $record->body }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-2"></div>    
                            @endforeach
                        </div>        
                    </div>
                </div>
                <br>
                <!--Create rating modal-->
    <div class="modal fade" tabindex="-1" role="dialog" id="createRating">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <!--Stars-->
                        <div>
                            <span id="star1" class="fas fa-star star" onclick="updateRating(event)"></span>
                            <span id="star2" class="fas fa-star star" onclick="updateRating(event)"></span>
                            <span id="star3" class="fas fa-star star" onclick="updateRating(event)"></span>
                            <span id="star4" class="fas fa-star star" onclick="updateRating(event)"></span>
                            <span id="star5" class="fas fa-star star" onclick="updateRating(event)"></span>
                        </div>
                    </h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ URL::route('Ratings.store','') }}" enctype="multipart/form-data" method="post" onsubmit='check()'>
                        @csrf

                        <div class="row">
                            <div class="col-8 offset-2">                       
                                <input id="rating" name="rating" type="hidden" value="0" />
                                <input id="prof_rated" name="professor_rated" type="hidden" value="{{$prof->id}}" />
                                <p id='rateError' style='color:red;'></p>
                                <!--Content-->
                                <div class="form-group row">
                                    <textarea name="body" id="body" cols="50" rows="4"
                                    class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}"
                                    autocomplete="body" autofocus placeholder="Add any comments here">{{ old('body') }}</textarea>
                                    @if ($errors->has('body'))
                                        <strong>{{ $errors->first('body') }}</strong>
                                    @endif
                                </div>

                                <!--Submit button-->
                                <div class="row pt-3 justify-content-center">
                                    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <div class="pr-3"></div>
                                    <button class="btn btn-primary">Submit Rating</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
