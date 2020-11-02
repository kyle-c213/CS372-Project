@extends('Layouts.app')

@section('title')
    {{$title ?? ''}}
@endsection

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-3 p-5">
            <img src="{{ asset($user->profile->profilePic())}}" alt="User picture" class="rounded-circle w-100">
        </div>
        <div class="col-9 pt-5 pl-2">
            <div class="d-flex justify-content-between align-items-baseline">
                <h1><strong>{{ $user->name }}</strong></h1>

                @can('update', $user->profile)
                    <a href="/profile/{{ $user->id }}/edit">Edit Profile</a>
                @endcan

            </div>
            <div>
                <h5> {{ $user->profile->major ?? 'No major' }}</h5>
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
            <div class="card card-index">
                <div class="card-header d-flex">
                    <h4 class="d-flex align-items-center">Recent Posts</h4>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection