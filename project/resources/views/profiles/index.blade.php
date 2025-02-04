@extends('Layouts.app')

@section('title')
    {{$title ?? ''}}
@endsection

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    var token = '{{ Session::token() }}';
    var urlDestroy = '{{ route('post.destroy') }}';
    var urlCom = '{{ route('comment.destroy') }}';

    function addContact()
    {
        var first_user = "{{auth()->user()->id}}";
        var second_user = "{{$user->id}}";
        var url = "{{route('contact.addContact')}}";

        jQuery.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'POST',
            data: jQuery.param({
                first_user: first_user,
                second_user: second_user
            }),
            dataType: false,
            cache: false,
            processData: false,      
            success: function(){
                var c = document.getElementById("contact");
                c.classList.remove("fa-user-plus");
                c.classList.add("fa-user-slash");
                c.parentElement.classList.add("text-danger");
                document.getElementById("contact2").innerHTML = " Remove contact";

                document.getElementById("contactLink").removeEventListener("click", addContact);
                document.getElementById("contactLink").addEventListener("click", removeContact);

                var contactsList = document.getElementById("contactsList");

                // if no contacts, remove first list element in contacts
                
                var li = document.createElement("li");
                var a = document.createElement("a");

                a.innerHTML = '{{\App\Models\User::where('id', $user->id)->first()->name}}';
                a.href='{{route("profile.show", $user->id)}}';

                li.appendChild(a);
                contactsList.appendChild(li);
            },
            error: function()
            {
                alert("Something went wrong");
            }
        });
    }

    function removeContact()
    {
        var first_user = "{{auth()->user()->id}}";
        var second_user = "{{$user->id}}";
        var url = "{{route('contact.removeContact')}}";

        jQuery.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'POST',
            data: jQuery.param({
                first_user: first_user,
                second_user: second_user
            }),
            dataType: false,
            cache: false,
            processData: false,      
            success: function(){
                var c = document.getElementById("contact");
                c.classList.remove("fa-user-slash");
                c.classList.add("fa-user-plus");
                document.getElementById("contactLink").classList.remove("text-danger");

                document.getElementById("contactLink").removeEventListener("click", removeContact);
                document.getElementById("contactLink").addEventListener("click", addContact);

                document.getElementById("contact2").innerHTML = " Add to contacts";


                // get user name for current page
                var currUserName = "{{\App\Models\User::where('id', $user->id)->first()->name}}";
                // get contact list
                var ul = document.getElementById("contactsList");
                // list of all li's in ul
                var listItems = ul.childNodes;
                for (var i = 0; i < listItems.length; i++)
                {
                    if (listItems[i].firstElementChild != null && listItems[i].firstElementChild.innerHTML === currUserName)
                    {
                        ul.removeChild(listItems[i]);
                        break;
                    }
                }
            },
            error: function()
            {
                alert("Something went wrong");
            }
        });
    }

    // image is placed in modal for enlargement
    function enlargeImage(event, count)
    {
        $('#imagepreview').attr('src', $('#image' + count).attr('src')); // here asign the image to the modal when the user click the enlarge link
        $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
    }

   function handleClick()
    {
        this.value = (this.value == 'Show Comments' ? 'Hide comments' : 'Show Comments');
    }
    document.getElementById('comment-collapse').onclick=handleClick;

</script>

<style>
    /*Dim image on hover*/
    .dim:hover {
        filter: brightness(50%);
        -moz-transition: all 0.5s;
        -webkit-transition: all 0.5s;
        transition: all 0.5s;
    }
</style>

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-3 p-5">
            <img src="{{ asset('/storage/'.config('chatify.user_avatar.folder').'/'. \App\Models\User::where('id', $user->id)->first()->avatar) }}" alt="User picture" class="rounded-circle w-100">
        </div>
        <div class="col-9 pt-5 pl-2">
            <div class="d-flex justify-content-between align-items-baseline">
                <h1><strong>{{ $user->name }}</strong></h1>

                @can('update', $user->profile)
                    <a href="{{ route('profile.edit', $user->id) }}"><span class="fas fa-edit"></span> Edit Profile</a>                    
                @else
                    @if($isContact)                       
                        <a href="#" id="contactLink" class="text-danger"><span id="contact" class="fas fa-user-slash"></span><span id="contact2"> Remove contact</span></a>                
                        <script>document.getElementById("contactLink").addEventListener("click", removeContact);</script>
                    @else
                        <a href="#" id="contactLink"><span id="contact" class="fas fa-user-plus"></span><span id="contact2"> Add to contacts<span></a>
                        <script>document.getElementById("contactLink").addEventListener("click", addContact);</script>
                    @endif
                @endcan
            </div>               
            <div class="d-flex justify-content-between align-items-baseline">
                <h5> {{ $user->profile->major ?? 'No major' }}</h5>
                <a href="{{route('listing.show', $user->id)}}"><span class="fas fa-store"></span> View listings</a>
            </div>
            <div class="d-flex justify-content-between align-items-baseline">
                <h5> {{ $user->profile->school ?? 'N/A' }} </h5>
            </div>
            <div>
                <aside> {{ $user->profile->bio }} </aside>     
            </div>
        </div>    
    </div>

    <hr style="border-top: 1px solid black;margin-top: -10px;" >

    <div class="row">
        <div class="col-12 pl-3 pr-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-baseline">
                    @can('update', $user->profile)
                        <h4>Your Posts</h4>
                        <a href='#' data-toggle="modal" data-target="#createPost"><span class="fas fa-pen"></span> Create New Post</a>
                    @else
                        <h4>{{$user->name}}'s posts</h4>
                    @endcan        
                </div>
                <div class="card-body">
                @if(!$user->posts->isEmpty())
                    <?php $count=0; ?>
                    @foreach($user->posts as $post)
                        <?php $count++; ?>
                        <!-- Head of post, includes poster's name, date posted, etc... -->
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center edit">
                                    <img src="{{ asset('/storage/'.config('chatify.user_avatar.folder').'/'. \App\Models\User::where('id', $post->user->id)->first()->avatar) }}"
                                        alt="pic" class="rounded-circle" style="max-width: 35px;">
                                    <h5 class="pl-2 pt-1"><a href="{{ route('profile.show', $post->user->id) }}" style="color:black;"><strong>{{ $post->user->name }}</strong></a></h5>
                                    @can('update', $user->profile)
                                        <div class="flex-grow-1"></div>
                                        <a href="#" data-postid="{{ $post->id }}"data-toggle="modal" data-target="#editPost" class="editPost">Edit Post</a>
                                    @endcan
                                </div>
                                <div class="d-flex justify-content-between delete" data-postid="{{ $post->id }}">
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
                                    @can('update', $user->profile)
                                        <a href='#' class="dltPost">Delete Post</a>
                                    @endcan
                                </div>
                            </div>

                            <!--  Content of post  -->   
                            <div class="card-body" data-postid="{{ $post->id }}" data-count="{{ $count }}">
                                <div class="d-flex justify-content-between">
                                    <h3><strong>{{ $post->title }}</strong></h3>
                                    @if($post->course_id)
                                        <h5>{{$post->course->class_name}}</h5>
                                    @endif
                                </div> 
                                
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
                            
                                <a href="#" onlcick="handleClick()" id ="comment-collapse" data-toggle="collapse" data-target="#showComments{{$count}}">Show Comments<span class="fas fa-caret-down"></span></a>
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
                                            <body> 
                                                <textarea name="bodyComment" id="bodyComment{{$count}}" rows="1" cols="50" placeholder="Write a Comment"></textarea>
                                            </body>
                                                <div class="pr-1"></div>
                                                <button name="saveComment" id="saveComment" class="btn btn-primary"><span class ="far fa-arrow-alt-circle-up" style="height: 12px;"></span></button>
                                        </div>
                                    </form>
                                </div>    
                            </div>
                        </div>
                        <!-- Padding between Posts-->
                        <div class="pt-2"></div>    
                    @endforeach
                @else
                    <div class="d-flex justify-content-center">
                        <h3><strong>No posts to show</strong></h3>
                    </div>    
                @endif    
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Post modal -->
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

    <!--Create post modal-->
    <div class="modal fade" tabindex="-1" role="dialog" id="createPost">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create New Post</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('post.store') }}" enctype="multipart/form-data" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-8 offset-2">
                                <!--Title-->
                                <div class="form-group row">    
                                    <label for="title" class="col-md-4 col-form-label">Post title</label>
                                    <input type="text" name ="title" id="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                    value="{{ old('title') }}" autocomplete="title" autofocus>

                                    @if ($errors->has('title'))
                                        <strong>{{ $errors->first('title') }}</strong>
                                    @endif
                                </div>

                                <!--Content-->
                                <div class="form-group row">
                                    <label for="body" class="col-md-4 col-form-label">Content</label>
                                    <textarea name="body" id="body" cols="50" rows="4"
                                    class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}"
                                    autocomplete="body" autofocus>{{ old('body') }}</textarea>

                                    @if ($errors->has('body'))
                                        <strong>{{ $errors->first('body') }}</strong>
                                    @endif
                                </div>

                                <!--Optional file upload-->
                                <div class="row">
                                    <label for="pic" class="col-md-4 col-form-label">Picture</label>
                                    <input type="file" class="form-control-file" id="pic" name="pic">

                                    @if ($errors->has('pic'))
                                        <strong>{{ $errors->first('pic') }}</strong>
                                    @endif
                                </div>

                                <?php
                                    use \App\Models\ClassMember;
                                    use \App\Models\Course;
                                    $user_joined_classes = ClassMember::select('course_id')->where('user_id', auth()->user()->id)->get();
                                    $classes = array();
                                    foreach($user_joined_classes as $u=>$val)
                                    {
                                        array_push($classes, Course::where('id', $val->course_id)->first());
                                    }
                                ?>
                                <!-- Class Selection -->
                                <div class="row pt-3">
                                    <label for="course_id" class="col-md-4 col-form-label">Class</label>
                                    <select id="course_id" name="course_id">
                                            <option value="">Your profile</option>
                                        @forelse($classes as $class)
                                            <option value="{{$class->id}}">{{$class->class_name}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>

                                <!--Submit button-->
                                <div class="row pt-3 justify-content-center">
                                    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <div class="pr-3"></div>
                                    <button class="btn btn-primary">Add New Post</button>
                                </div>
                            </div>
                        </div>
                    </form>
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
                                <!-- post id --hidden  -->
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

    <!--Contact list modal-->
    <div class="modal fade" tabindex="-1" role="dialog" id="contactList">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Contacts</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="userContacts" class="table table-borderless">         
                            @foreach($contacts as $key=>$val)
                            <?php
                                $c = \App\Models\User::where('id', $val->second_user)->first()->name;
                            ?>
                            <tr>
                                <td style="width:80%">{{$c}}</td>
                                <td><span class="fas fa-comment"></span></td>
                                <td><a href="#" onclick="removeContact()" class="text-danger"><span id="contactModal" class="fas fa-user-slash"></span><span id="contact2"></a></td>
                            </tr>
                            @endforeach                     
                    </table>
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
</div>

@endsection