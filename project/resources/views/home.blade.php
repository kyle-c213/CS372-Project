@extends('layouts.app')



@if (session('status'))
    <div class="alert alert-success" role="alert">
       {{ session('status') }}                        
    </div>
@endif
<!--{{ __('You are logged in!') }}-->



@section('content')


{{-- <div class="container-fluid py-4">

    <div id="showChat" class="fixed-bottom-right" class="fa-4x">
        <span class="fa-stack fa-2x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <a id="chat" class="fas fa-comments fa-stack-1x fa-inverse" href="{{route('chat')}}" style="text-decoration: none;"></a>
          </span>
    </div> --}}

    {{-- <div class="row-fluid"> --}}

    {{-- <div class="col">
        @include('inc.sidebar')
    </div> --}}


        {{-- <div class="col col-md-8"> --}}
            <div class="card card-index">
                <div class="card-header">
                    <h2>Make a Post</h2>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <textarea name="body" cols="40" rows="5" class="form-control"></textarea>
                        <label for="Classes">Choose a Class</label>
                        <select id="Classes" name="Classes">
                            <option value="All">All</option>
                            <option value="CS372">CS372</option>
                            <option value="CS340">CS340</option>
                            <option value="Placeholders...">Placeholders...</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-right">Share</button>
                    </form>
                </div>
            </div>  
            <hr/>
            
            <div class="py-3">
                <div class="card">
                    <div class="card-header">
                        <h2>Updates From Your Classes</h2>
                </div> 
                    <div class="card-body">
                        
                        @foreach($posts as $p=>$post)
                            <!-- Head of post, includes posters name, date posted, etc... -->
                            <div class="py-2">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('/storage/'.config('chatify.user_avatar.folder').'/'. \App\Models\User::where('id', $post->user->id)->first()->avatar) }}"
                                                alt="pic" class="rounded-circle" style="max-width: 35px;">
                                            <h5 class="pl-2 pt-1"><strong>{{ $post->user->name }}</strong></h5>
                                            @can('update', $post->user->profile)
                                                <div class="flex-grow-1"></div>
                                                <a href="">Edit Post</a>
                                            @endcan
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="small pl-1 pt-1 text-muted">
                                                Created at: {{ $post->created_at->format('h:ia \\o\\n F d') }}
                                            </div>
                                            @can('update', $post->user->profile)
                                                <a href="">Delete Post</a>
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
                            </div>  
                        @endforeach
                    </div>        
                </div>
            </div>
        {{-- </div> --}}
        

        {{-- <div class="col">
            <!-- Contacts menu on Right-->
            @include('inc.contactsidebar')
        </div> --}}
    {{-- </div>
</div> --}}
{{-- </div> --}}
@endsection

