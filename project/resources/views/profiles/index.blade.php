@extends('Layouts.app')

@section('title')
    {{$title ?? ''}}
@endsection

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
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
                alert('Success!');
                var c = document.getElementById("contact");
                c.classList.remove("fa-user-plus");
                c.classList.add("fa-user-slash");
                c.parentElement.classList.add("text-danger");
                document.getElementById("contact2").innerHTML = " Remove contact";

                document.getElementById("contactLink").removeEventListener("click", addContact);
                document.getElementById("contactLink").addEventListener("click", removeContact);

                var contactsList = document.getElementById("contactsList");

                // if no contacts, remove first list element in contacts
                // contactsList.removeChild(contactsList.getElementsByTagName('li')[0]);

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
                alert('Success!');
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
</script>

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
                    <a href="/profile/{{ $user->id }}/edit"><span class="fas fa-edit"></span> Edit Profile</a>                    
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
                @can('update', $user->profile)
                    <a href="#" data-toggle="modal" data-target="#contactList"><span class="fas fa-user-friends"></span> View contacts</a>
                @endcan
            </div>
            <div>
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
                    @foreach($user->posts as $post)
                        <!-- Head of post, includes poster's name, date posted, etc... -->
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('/storage/'.config('chatify.user_avatar.folder').'/'. \App\Models\User::where('id', $post->user->id)->first()->avatar) }}"
                                        alt="pic" class="rounded-circle" style="max-width: 35px;">
                                    <h5 class="pl-2 pt-1"><strong>{{ $post->user->name }}</strong></h5>
                                    @can('update', $user->profile)
                                        <div class="flex-grow-1"></div>
                                        <a href="">Edit Post</a>
                                    @endcan
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="small pl-1 pt-1 text-muted">
                                        Created at: {{ $post->created_at->format('h:ma \\o\\n F d') }}
                                    </div>
                                    @can('update', $user->profile)
                                        <form action="{{ url('post.destroy', ['post_id' => $post->id ]) }}">
                                            <input type="hidden" name="_method" value="delete" />
                                            <a href="">Delete Post</a>
                                        </form>
                                    @endcan
                                </div>
                            </div>

                            <!--  Content of post  -->   
                            <div class="card-body">
                                <h3>{{ $post->title }}</h3>
                                <div>
                                    <p>
                                        {{ $post->body }}
                                    </p>
                                </div>
                            </div>
                        </div>    
                    @endforeach
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
                    <form action="{{ URL::route('post.store','') }}" enctype="multipart/form-data" method="post">
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
                                
                                <!-- ***IMPLEMENT CLASS THEN UNCOMMENT*** 
                                <!--Class selection--
                                <div class="row">
                                    <label for="classSelect" class="col-md-4 col-form-label">Select Class</label>
                                    <select name="classSelect" id="classSelect" class="w-50">
                                        <!--Need classes to be implemented...--
                                        <option value="All" selected>All</option>
                                        foreach()

                                        endforeach                                    
                                    </select>
                                </div>
                                -->

                                <!--Optional file upload-->
                                <div class="row">
                                    <label for="file" class="col-md-4 col-form-label">File</label>
                                    <input type="file" class="form-control-file" id="file" name="file">

                                    @if ($errors->has('file'))
                                        <strong>{{ $errors->first('file') }}</strong>
                                    @endif
                                </div>

                                <!--Submit button-->
                                <div class="row pt-3 justify-content-center">
                                    <button class="btn btn-primary">Add New Post</button>
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
</div>
@endsection