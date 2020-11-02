@extends('Layouts.app')

@section('title')
    {{$title ?? ''}}
@endsection


@section('content')
<div class="container">
    <form action="/profile/{{ $user->id }}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @method('PATCH')
        
        <div class="row">
            <div class="col-8 offset-2">
                <div class="row pt-4">
                    <h1>Edit your Profile</h1>
                </div>

                <div class="row">
                    <label for="major" class="col-md-4 col-form-label">Major</label>

                    <input id="major" type="text" name="major"
                    class="form-control{{$errors->has('major') ? ' is_invalid' : '' }}"
                    value="{{ old('major') ?? $user->profile->major }}" autocomplete="major" autofoucs>

                    @if ($errors->has('major'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('major') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="row">
                    <label for="school" class="col-md-4 col-form-label">School</label>

                    <input id="school" type="text" name="school"
                    class="form-control{{$errors->has('school') ? ' is_invalid' : '' }}"
                    value="{{ old('school') ?? $user->profile->school }}" autocomplete="school" autofoucs>

                    @if ($errors->has('school'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('school') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="row">
                    <label for="bio" class="col-md-4 col-form-label">Bio</label>

                    <textarea id="bio" type="text" name="bio"
                    class="form-control{{$errors->has('bio') ? ' is_invalid' : '' }}"
                    value="{{ old('bio') ?? $user->profile->bio }}" autocomplete="bio" autofoucs
                    rows="4" cols="50">
                    </textarea>

                    @if ($errors->has('bio'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('bio') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="row">
                    <label for="picture" class="col-md-4 col-form-label">Profile Picture</label>

                    <input type="file" class="form-control-file" id="picture" name="picture">
                    @if($errors->has('picture'))
                        <strong>{{ $errors->first('picture') }}</strong>
                    @endif
                </div>

                <div class="pt-4 row">
                    <button class="btn btn-primary">Update Profile</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection