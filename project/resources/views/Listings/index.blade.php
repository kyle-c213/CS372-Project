@extends('layouts.app')

@section('content')

<button class="btn btn-primary p-2" onclick="window.location.href='{{route('listing.create')}}';">Create listing</button>
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
                    <a href="{{route("contact.email", $val->posted_by)}}" style="float: right;">Contact Seller</a>
                </div>
            </div>
            <span class="text-secondary">${{number_format($val->price, 2)}}</span>
        </div>
        <div class="card-body">
            <p>{{$val->description}}</p>
            <small class="text-secondary">Posted by {{\App\Models\User::where('id', $val->posted_by)->first()->name}} at {{$val->created_at->format('h:m a \\o\\n F d')}}</small>
        </div>
    </div>
</div>
@endforeach

@endsection