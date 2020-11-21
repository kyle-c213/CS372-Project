@extends('layouts.app')

@section('content')

    <h2>What are you selling?</h2>

    <div class="form-group">
        <form id="sale" action="{{route('listing.create_post')}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @method('POST')
            <label>Price</label>
            <input class="form-control col-md-2" type="text"/>
            <label>Ad Title</label>
            <input class="form-control col-md-6" type="text"/>
            <label>Describe your item here!</label>
            <textarea class="form-control" placeholder="Enter an item description..."></textarea>
        </form>
    </div>

@endsection