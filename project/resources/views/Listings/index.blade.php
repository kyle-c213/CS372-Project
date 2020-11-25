@extends('layouts.app')

<style>
    /*Dim image on hover*/
    .dim:hover {
        filter: brightness(50%);
        -moz-transition: all 0.5s;
        -webkit-transition: all 0.5s;
        transition: all 0.5s;
    }
</style>

<script>
// image is placed in modal for enlargement
function enlargeImage(event, count)
{
   $('#imagepreview').attr('src', $('#image' + count).attr('src')); // here asign the image to the modal when the user click the enlarge link
   $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
}
</script>

@section('content')


<button class="btn btn-primary p-2 btn-block" onclick="window.location.href='{{route('listing.create')}}';">Create Listing</button>
<button class="btn btn-dark p-2 btn-block" onclick="window.location.href='{{route('listing.show', auth()->user()->id)}}';">View Your Listings</button>
<button class="btn btn-secondary p-2 btn-block" onclick="window.location.href='{{route('mail.index')}}';">View Your Inbox ({{$messages}})</button>

<br/>
<h1>Recent Listings</h1>
<hr/>
<?php $count = 0; ?>
@foreach($listings as $l=>$val)
<?php $count++; ?>
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
                <a href="#responsive" id="enlarge" onclick="enlargeImage(event, '{{$count}}')">
                    <img id="image{{$count}}" src='{{$val->getPicture()}}' width="200" height="200" alt="No picture found for this item" class="rounded dim"/>
                </a>
            </p>
            <hr/>
            <p>{{$val->description}}</p>
            <small class="text-secondary">Posted by {{\App\Models\User::where('id', $val->posted_by)->first()->name}} at {{$val->created_at->format('h:i a \\o\\n F d')}}</small>
        </div>
    </div>
</div>
  
@endforeach

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

@endsection