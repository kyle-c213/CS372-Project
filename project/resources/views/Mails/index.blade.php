@extends('layouts.app')

@section('content')

<button class="btn btn-primary p-2 btn-block" onclick="window.location.href='{{route('listing.create')}}';">Create Listing</button>
<button class="btn btn-dark p-2 btn-block" onclick="window.location.href='{{route('listing.index')}}';">View All Listings</button>
<br/>
<h1>Your Buy and Sell Inbox <a href="#" data-toggle="collapse" data-target="#info"><span class="fas fa-info-circle text-info"></span></a></h1>
<div id="info" class="collapse">
    <p class="bg-info text-white p-3 rounded">
        Communication in regards to buying and selling items can be done here. To start messaging, find an item you wish to purchase and select "Contact Seller".
        If you are selling an item, messages from interested buyers will be displayed here.
    </p>
</div>
<table class="table">
    <tr>
        <th>Title</th>
        <th>From</th>
        <th>Received At</th>
    </tr>
    @foreach($rec_mails as $m=>$val)
    <?php 
        // check if it is unread
        $color = "#f8fafc";
        if ($val->opened == false)
        {
            $color = "#ffeaa3";
        }
    ?>
    <tr style="background-color: {{$color}}">
        <td><a href="{{route('mail.show', $val->id)}}">{{$val->title}}</a></td>
        <td>{{\App\Models\User::where('id', $val->from)->first()->name}}</td>
        <td>{{$val->created_at->format('h:ia F d')}}</td>
    </tr>
    @endforeach
    
</table>

@endsection