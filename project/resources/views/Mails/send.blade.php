@extends('layouts.app')

<?php 
    // $listingTitle = listing->title
?>

<style>
    #body{
        width: 100%;
        height: 50%;
    }
</style>

<script>
    window.onload = function() {
        $("#title").val("Concerning " + "\"{{$listing->title}}\"");
        $("#body").val("Hi " + "{{\App\Models\User::where('id', $user->id)->first()->name}},\n" + "I am interest in purchasing this item.\n" + "Thanks,\n" + "{{\App\Models\User::where('id', auth()->user()->id)->first()->name}}");
    };
    // $(document).ready(function(){
        
    // });
</script>

@section('content')

<form action="{{route('mail.send_post')}}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="to_id" value="{{$user->id}}"/>
    <input type="hidden" name="listing_id" value="{{$listing->id}}"/>
    <div class="form-group">
        <label><b>Sending to: {{\App\Models\User::where('id', $user->id)->first()->name}}</b></label>
    </div>
    <div class="form-group">
        <label>Title</label>
        <input name="title" id="title" type="text" class="form-control"/>
    </div>
    <div class="form-group">
        <label>Body</label>
        <textarea name="body" id="body" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Send Email" onclick="warn()"/>
    </div>
</form>

@endsection