@extends('layouts.app')

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

<style>
    a.unlink {
    color: inherit;
    }
    a.unlink:hover {
    color: inherit;
    }

    button.limit{
        display: block;
        width: 170px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>


@section('content')
    <div class="text-center top-page">
        <h1>{{ $class->class_name }}</h1>  <!--Placeholder for class name -->
        <h5 class="text-secondary font-italic"><a class="unlink" href="{{route('profRate.show', $prof->id)}}">{{$prof->name}}</a></h5> <!-- place holder for profs name-->
        <h6 class="text-secondary">{{$class->semester}} {{$class->year}}</h6>
        <button class="btn btn-outline-primary" onclick="window.location.href='{{route('class.join', ['class_id' => $class->id])}}';">Join</button>
        <button class="btn btn-outline-danger" onclick="window.location.href='{{route('class.leave', ['class_id' => $class->id])}}';">Leave</button>
    </div>

    <hr/>

    <div class="card card-index">
        <div class="card-header">
            <h2>Make a Post</h2>
        </div>
        <form action="{{ route('post.store') }}" enctype="multipart/form-data" method="post">
            @csrf

            <div class="card-body p-4">
                <div class="form-group row">
                    <label for="title">Post Title</label>
                    <input type="text" name="title" id="title" class="form-control">
                </div>

                <div class="form-group row">
                    <label for="body">Content</label>
                    <textarea name="body" cols="40" rows="5" class="form-control"></textarea>
                </div>

                <div class="form-group row">
                    <label for="pic" class="pr-3">Picture</label>
                    <input type="file" class="form-control col-md-4" id="pic" name="pic">
                </div>

                <input type="hidden" name="class" value="{{$class->id}}" />

                <div class="form-group row">
                    <input type="submit" class="btn btn-primary" value="Share"/>
                </div>
            </div>
        </form>
    </div>

    <div class="pt-3 pb-3"></div>

    <div class="card">
        <div class="card-header">
            <h4>Updates from {{$class->class_name}}</h4>
        </div> 
        <div class="card-body">
            <!-- No Posts to show -->
            @if($posts->count() == 0)
                <div class="d-flex justify-content-center">
                    <h3><strong>No posts to show</strong></h3>
                </div>
            @endif 

            <?php $count=0; ?>
            @foreach($posts as $p=>$post)
                <?php $count++; ?>
                <!-- Head of post, includes posters name, date posted, etc... -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center edit">
                            <img src="{{ asset('/storage/'.config('chatify.user_avatar.folder').'/'. \App\Models\User::where('id', $post->user->id)->first()->avatar) }}"
                                alt="pic" class="rounded-circle" style="max-width: 35px;">
                            <h5 class="pl-2 pt-1"><a href="{{ route('profile.show', $post->user->id) }}" style="color:black;"><strong>{{ $post->user->name }}</strong></a></h5>
                            @can('update', $post->user->profile)
                                <div class="flex-grow-1"></div>
                                <a href="#" data-postid="{{ $post->id }}"data-toggle="modal" data-target="#editPost" class="editPost">Edit Post</a>
                            @endcan
                        </div>
                        <div class="d-flex justify-content-between delete"  data-postid="{{ $post->id }}">
                            <div>
                                <table class="small pl-1 pt-1 text-muted">
                                    <tr>
                                        <td class="pr-2">Created at: {{ $post->created_at->format('h:ia \\o\\n F d') }}</td>
                                        @if($post->created_at != $post->updated_at)
                                            <td style="border-left:1px solid #ccc;" class="pl-2">Updated at: {{ $post->updated_at->format('h:ia \\o\\n F d') }}</td>
                                        @endif
                                    </tr>
                                </table>
                            </div>
                            @can('update', $post->user->profile)
                                <a href="#" class="dltPost">Delete Post</a>
                            @endcan
                        </div>
                    </div>

                    <!--  Content of post  -->   
                    <div class="card-body" data-postid="{{ $post->id }}" data-count="{{ $count }}">
                        <h3><strong>{{ $post->title }}</strong></h3>
                        <hr style="border-top: 1px solid #D3D3D3; margin-top: -5px;" >
                        <div class="d-flex justify-content-between">
                            <p class="pt-1">
                                {{ $post->body }}
                            </p>
                            @if($post->pic)
                                <a href="#responsive" class="pr-3" id="enlarge" onclick="enlargeImage(event, '{{$count}}')">
                                    <img src="/storage/{{ $post->pic }}" width="200" height="200" id="image{{$count}}" class="rounded dim">
                                </a>
                            @endif
                        </div>

                        <hr style="border-top: 1px solid #D3D3D3;" >
                    
                        <a href="#" id ="comment-collapse" data-toggle="collapse" data-target="#showComments{{$count}}">Show Comments<span class="fas fa-caret-down"></span></a>
                        <div class="collapse" id="showComments{{$count}}">
                            @forelse($post->comments as $comment)
                                <div class="d-flex align-items-center comments" data-commentid="{{$comment->id}}">
                                    <img src="{{ asset('/storage/'.config('chatify.user_avatar.folder').'/'. \App\Models\User::where('id', $comment->user->id)->first()->avatar) }}"
                                        alt="pic" class="rounded-circle" style="max-width: 25px;">
                                    <p class="pl-2 pt-3"><a href="{{ route('profile.show', $comment->user->id) }}" style="color:black;"><strong>{{ $comment->user->name }}</strong></a></p>
                                    <span class="pl-3 small text-muted">Created at: {{ $comment->created_at->format('h:ia \\o\\n F d') }}</span>
                                    @if($comment->user->id == Auth::id())
                                        <div class="flex-grow-1"></div>
                                        <a href='#' class="dltComment">Delete Comment</a>
                                    @endif
                                </div>
                                <hr style="border-top: 1px solid #D3D3D3; margin-top:-5px;">
                                <p>{{ $comment->body }}</p>  
                            @empty
                                <p>No comments to show</p>
                            @endforelse
                        </div>
                        <div class="pt-3">
                            <form action="{{ route('comments.store') }}" enctype="multipart/form-data" method="post">
                                @csrf
                                <input type="hidden" id="post_id" name="post_id" value="{{ $post->id }}">
                                <div class="d-flex align-items-baseline">
                                    <body onload="init('{{$count}}')"> 
                                        <textarea name="bodyComment" id="bodyComment{{$count}}" rows="1" cols="50" placeholder="Write a Comment"></textarea>
                                    </body>
                                    <div class="pr-1"></div>
                                    <button name="saveComment" id="saveComment" class="btn btn-primary"><span class ="far fa-arrow-alt-circle-up" style="height: 12px;"></span></button>
                                </div>
                            </form>
                        </div>    
                    </div>
                </div>
                <div class="pt-2"></div>    
            @endforeach
        </div>        
    </div>
{{-- </div> --}}


{{-- <div class="col">
    <!-- Contacts menu on Right-->
    @include('inc.contactsidebar')
</div> --}}
{{-- </div>
</div> --}}

<!-- Delete Post modal-->
<div class="modal fade" tabindex="-1" role=dialog id="deletePost"> 
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Delete Post</h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>
                <strong>This will erase the post and will not be reversable!</strong>
            </p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-primary" id="modal-delete">Confirm</a>
            <a href="#" data-dismiss="modal" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</div>
</div>

<!--Edit Post Modal-->
<div class="modal fade" tabindex="-1" role="dialog" id="editPost">
<div class="modal-dialog modal-dialog-centered" role="document">            
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Edit Post</h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('post.edit') }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="row">
                    <div class="col-8 offset-2">
                        <!-- post id - hidden  -->
                        <input type="hidden" name="editPID" id="editPID">
                        <!--Title-->
                        <div class="form-group row">    
                            <label for="editTitle" class="col-md-4 col-form-label">Post title</label>
                            <input type="text" name ="editTitle" id="editTitle">
                        </div>

                        <!--Content-->
                        <div class="form-group row">
                            <label for="editBody" class="col-md-4 col-form-label">Content</label>
                            <textarea name="editBody" id="editBody" cols="50" rows="4"></textarea>
                        </div>

                        <!--pic upload-->
                        <div class="form-group row">
                            <label for="editPic" class="col-md-4 col-form-label">Picture</label>
                            <input type="file" class="form-control-file" id="editPic" name="editPic">
                        </div>

                        <!--Submit button-->
                        <div class="row pt-3 justify-content-center">
                            <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <div class="pr-3"></div>
                            <button class="btn btn-primary" id="modal-save">Update Post</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<!-- Modal to show enlarged image -->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Image preview</h4>
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </div>
        <div class="modal-body">
            <p class="text-center">
                <img src="" id="imagepreview" style="max-width: 400px; max-height: 300px;" >
            </p>
        </div>
    </div>
</div>
</div>

<!-- Modal to add new important date -->
<div class="modal fade" id="addDate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Add An Event</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <p class="text-center">
                    <form action="{{route('event.add')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label><b>Adding event for {{$class->class_name}}</b></label>
                            <input type="hidden" value="{{$class->id}}" name="course_id"/>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="title" placeholder="Event name"/>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="body" placeholder="Describe the event"/>
                        </div>
                        <div class="form-group">
                            <input id="datetime" class="date form-control" name="due_date" type="text" placeholder="Date" />
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Add"/>
                        </div>
                    </form>
                </p>
            </div>
        </div>
    </div>
    </div>




<br><br>


@endsection


@section('class_members')
<div class="card-header">
    <h2 class="">Members</h2>
</div>
<div class="card-body">
    <button class="btn btn-block btn-outline-secondary" onclick="window.location.href='{{route('class.members', ['class_id' => $class->id])}}';">View All Members</button>
    <hr/>
    <ul class="nav flex-column" id="membersList">
        <?php
            $hasMembers = false;
        ?>
        @foreach($members as $key=>$val)
            <?php
                $hasMembers = true;
                $memberName = \App\Models\User::where('id', $val->user_id)->first()->name;
            ?>
            <li class="p-1">                           
                <a href="{{route('profile.show', $val->user_id)}}">{{$memberName}}</a>
                {{-- if we want to include images on contacts panel <img src="{{ asset('/storage/'.config('chatify.user_avatar.folder').'/'. \App\Models\User::where('id', $val->second_user)->first()->avatar) }}" class="rounded-circle float-right" style="width:25px;max-width:25px;"> --}}
                {{-- <span class="fas fa-comment"></span> can be added later for quick messaging --}}
            </li>
        @endforeach
        @if($hasMembers == false)
        <li id="noMembersMessage">
            This class has no members!
        </li>
        @endif
    </ul>
</div>
<script src="/js/moment.min.js"></script>
<script src="/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">

    $('.date').datepicker({  

       format: 'dd-mm-yyyy'

     });  

</script> 

@endsection

@section('importantdates')
    <div class="card-header">
        <h2 class="">Events</h2>
    </div>
    <div class="card-body">
        <button class="btn btn-block btn-outline-secondary" data-toggle="modal" data-target="#addDate">Add An Event</button>
        <hr/>
        @forelse($events as $e)
    <button onclick="window.location.href='{{route('event.show', ['id' => $e->id])}}';" class="btn btn-block btn-light limit">{{$e->due_date->format('M j')}}: {{$e->title}}</button>
        @empty
        @endforelse
    </div>
@endsection

@section('classlistings')
    <div class="card-header">
        <h2 class="">Listings</h2>
    </div>
    <div class="card-body">
        @forelse($listings as $l=>$val)
            <button class="btn btn-block btn-light limit" onclick="window.location.href='{{route('listing.details', ['listing_id' => $val->id])}}';">{{$val->title}} - ${{$val->price}}</button>
        @empty
            <span>No class listings yet!</span>
        @endforelse
    </div>
@endsection




