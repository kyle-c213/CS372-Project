@extends('Layouts.app')

<!-- Main body content-->
@section('content')
    <div class="container " id="body">
        <div class="row justify-content-center">
            <div class="col-md-8">
            <!--remove, just put form to get new rating here-->
                <div class="form-group row">
                    <label for="name"
                        class="col-md-4 col-form-label text-md-right">{{ __('Name') }}
                    </label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            <!--end of remove-->   
            </div>
        </div>
    </div>
@endsection
