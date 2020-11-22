@extends('layouts.app')

<?php 
    // check if the mail is a reply to a previous message
    $isReply = false;
    if ($mail->child_of != null)
    {
        $isReply = true;
    }
?>

@section('content')

<h2>{{$mail->title}}</h2>
<span class="text-secondary">From {{\App\Models\User::where('id', $mail->from)->first()->name}}</span>
@if($isReply)
    <br/>
    <span>Replying to "{{\App\Models\Mail::where('id', $mail->child_of)->first()->title}}"</span>
@endif
<hr/>
<p>{{$mail->content}}</p>

<button class="btn btn-primary" data-toggle="modal" data-target="#reply"><span class="fas fa-reply"></span> Reply</button>
<div class="py-2">
<form action="{{route('mail.delete')}}" enctype="multipart/form-data" method="post">
    @csrf
    <input type="hidden" name="mail_id" value="{{$mail->id}}"/>
    <input type="submit" class="btn btn-danger" value="Delete"/>
</form>
</div>

<a href="{{route('mail.index')}}">Back to inbox</a>


<!--Modal for reply to mail-->
<div class="modal fade" tabindex="-1" role="dialog" id="reply">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reply to mail</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('mail.send_post')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <input type="hidden" name="to_id" value="{{$mail->from}}"/>
                    <input type="hidden" name="child_of" value="{{$mail->id}}"/>

                    <div class="row">
                        <div class="col-8 offset-2">
                            <!--Title-->
                            <div class="form-group row">    
                                <label for="title" class="col-md-4 col-form-label">Title</label>
                                <input type="text" name ="title" id="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                value="{{ old('title') }}" autocomplete="title" autofocus>

                                @if ($errors->has('title'))
                                    <strong>{{ $errors->first('title') }}</strong>
                                @endif
                            </div>

                            <!--Content-->
                            <div class="form-group row">
                                <label for="body" class="col-md-4 col-form-label">Content</label>
                                <textarea name="body" id="body" cols="50" rows="4"
                                class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }}"
                                autocomplete="body" autofocus>{{ old('body') }}</textarea>

                                @if ($errors->has('body'))
                                    <strong>{{ $errors->first('body') }}</strong>
                                @endif
                            </div>
                            
                            <!--Submit button-->
                            <div class="row pt-3 justify-content-center">
                                <button class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection