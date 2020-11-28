@extends('layouts.app')

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
                    <h4 id='avgRating' >
                    @if ($avgRate == -1)
                        <!-- the list that holds results -->No ratings yet
                    @else
                        <!--the list that holds results-->{{$avgRate}}
                    @endif
                    </h4>
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
                                    <h5 class="pl-2 pt-1"><a href="{{ route('profile.show', $record->rated_by) }}" style="color:black;"><strong>{{ $record->rated_by->name }}</strong></a></h5>
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
                                <h3><strong>{{ $record->rating }}</strong></h3>
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
                <div name="PRate" class="card py-4 px-4">
                    <h3>Rate Here</h3>
                    <!--
                        to be gathered in the form:
                            rating, class, comments
                        gathered but not entered:
                            prof id, user id
                    -->
                    <form name="ratingSub" id="ratingSub" action="store" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type='hidden' id='professor_rated' name='professor_rated' value='{{$prof->id}}' class="form-control" />
                        <p> Enter class ID for rated class for: <input type="text" name="class_taken" id="class_taken" class="form-control"></p>
                        <p> Enter professor rating (1-5): <input type="text" name="rating" id="rating" class="form-control"></p>
                        <textarea id="comments" style="height:150;" placeholder="Add comments here" class="form-control"></textarea>
                        <br/>
                        <p><input type="submit" value="Add Rating" class="btn btn-primary"></p>
                    </form>
                </div>
    </div>
@endsection
