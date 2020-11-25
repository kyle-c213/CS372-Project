@extends('layouts.app')

@section('content')

<p class="p-3 mb-2 bg-info text-white"><span class="fas fa-info-circle"></span> Sending a message to the seller will start an email conversation. <a style="color:blue;" href="#" data-toggle="collapse" data-target="#info">Show more</a></p>
<div id="info" class="collapse">
    <p class="bg-info text-white p-3">
        By clicking send email, you will be allowing the receipient to see your email address. If you wish to keep your email hidden you may find the seller in the message center.
        In your email, please be specific as to which item you are interested in.
    </p>
</div>
<form>
    <div class="form-group">
        <label>Title</label>
        <input type="text" class="form-control"/>
    </div>
    <div class="form-group">
        <label>Body</label>
        <textarea class="form-control"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Send Email" onclick="warn()"/>
    </div>
</form>



@endsection