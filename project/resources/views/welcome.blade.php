@extends('Layouts.app')

<style>
    body{
        height:100%;
        overflow: hidden;  
    }

    .split {
  height: 100%;
  width: 50%;
  position: fixed;
  z-index: 1;
  overflow-x: hidden;
}

.left {
  left: 0;
  background-color: #111;
}

.right {
  right: 0;
}
    /* main{
        background-image: url("{{asset('images/uofr3.jpg')}}");
        background-position: center center; 
        background-attachment: fixed; 
        background-repeat: no-repeat; background-size: cover; 
        height:100%;
        overflow: hidden;
    } */

    .mainBox{
        background-color: rgba(255,255,255,0.6);
        border: solid black 1px;
        padding:10px;
    }

    .blurb1{
        position:relative;
        top:275;
        left:350;
    }

    .blurb2{
        position:relative;
        top:300;
        left:350;
    }

    .blurb3{
        position:relative;
        top:325;
        left:350;
    }

    a.button1{
 display:inline-block;
 padding:0.35em 1.2em;
 border:0.1em solid #FFFFFF;
 margin:0 0.3em 0.3em 0;
 border-radius:0.12em;
 box-sizing: border-box;
 text-decoration:none;
 font-family:'Roboto',sans-serif;
 font-weight:300;
 color:#FFFFFF;
 text-align:center;
 transition: all 0.2s;
}
a.button1:hover{
 color:#000000;
 background-color:#FFFFFF;
}
</style>

@section('title')
    {{$title ?? ''}}
@endsection

@section('content')
<div class="container">
        <div class="split left" style='background-image: url("{{asset('images/welcome-background.jpg')}}"); background-repeat: no-repeat; background-size: cover;'>
            <h3 class="blurb1"><span class="fas fa-angle-double-right"></span> Connect with classmates</h3>
            <h3 class="blurb2"><span class="fas fa-angle-double-right"></span> Keep track of your classes</h3>
            <h3 class="blurb3"><span class="fas fa-angle-double-right"></span> Form study groups</h3>
        </div>


        <div class="split right">
    <div class="jumbotron m-t-3" style="background-color: rgba(255,255,255,0.9);">
        <h1 class="display-2 text-center">Student Zone</h1>    
        <p class="lead text-center">The social hub dedicated to students.</p>
    <hr class="m-y-2" />



    
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group row">
            {{-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> --}}

            <div class="col-md-4">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            {{-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> --}}

            <div class="col-md-4">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                </button>
                
                {{-- @if (Route::has('password.request'))
                    <br />
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif --}}
            </div>
        </div>
    </form> 
    
    <div class="signup">
        @if (Route::has('register'))
            <a class="btn btn-secondary" href="{{ route('register') }}">{{ __('Register') }}</a>
        @endif
    </div>
</div> 
    </div>   
</div>
@endsection