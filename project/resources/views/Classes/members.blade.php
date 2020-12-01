@extends('layouts.app')

<style>
    a.unlink {
    color: inherit;
    }
    a.unlink:hover {
    color: inherit;
    }
</style>


@section('content')

<div class="text-center top-page">
    <h1>{{ $class->class_name }} Members</h1>  
    <h5 class="text-secondary font-italic"><a class="unlink" href="{{route('profRate.show', $prof->id)}}">{{$prof->name}}</a></h5> 
    <h6 class="text-secondary">{{$class->semester}} {{$class->year}}</h6>
    <button class="btn btn-outline-primary" onclick="window.location.href='{{route('class.join', ['class_id' => $class->id])}}';">Join</button>
    <button class="btn btn-outline-danger" onclick="window.location.href='{{route('class.leave', ['class_id' => $class->id])}}';">Leave</button>
</div>

<hr/>

<table class="table">
    @forelse($users as $u)
    <tr>
        <td>
            <img src="{{ asset('/storage/'.config('chatify.user_avatar.folder').'/'. \App\Models\User::where('id', $u->user_id)->first()->avatar) }}"
            alt="pic" class="rounded-circle" style="max-width: 35px;">
            <a href="{{ route('profile.show', $u->user_id) }}">{{\App\Models\User::where('id', $u->user_id)->first()->name}}</a>
        </td>
        <td>Joined on {{$u->created_at->format('F d, Y') }}</td>
    </tr>
    @empty
        <tr>
            <td>There are no users in this class</td>
        </tr>
    @endforelse
</table>

@endsection