@extends('layouts.app')

@section('content')


<button class="btn btn-primary p-2 btn-block" onclick="window.location.href='{{route('listing.create')}}';">Create Listing</button>
<button class="btn btn-dark p-2 btn-block" onclick="window.location.href='{{route('listing.show', auth()->user()->id)}}';">View Your Listings</button>
<button class="btn btn-secondary p-2 btn-block" onclick="window.location.href='{{route('mail.index')}}';">View Your Inbox ({{$messages}})</button>

<br/>
<h1>Recent Listings</h1>
<hr/>
@foreach($listings as $l=>$val)
<!--Card for each listing-->
<div class="p-2">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8">
                    <h3>{{$val->title}}</h3>
                </div>
                <div class="col">
                    <a href="{{route("mail.send", ['to_id' => $val->posted_by, 'listing_id' => $val->id])}}" style="float: right;">Contact Seller</a>
                </div>
            </div>
            <span class="text-secondary">${{number_format($val->price, 2)}}</span>
        </div>
        <div class="card-body">
            <p class="text-center">
                <img  src='{{$val->getPicture()}}' width="200" height="200" alt="No picture found for this item" class="rounded"/>
            </p>
            <hr/>
            <p>{{$val->description}}</p>
            <small class="text-secondary">Posted by {{\App\Models\User::where('id', $val->posted_by)->first()->name}} at {{$val->created_at->format('h:i a \\o\\n F d')}}</small>
        </div>
    </div>
</div>
@endforeach

@endsection