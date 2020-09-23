<nav class="navbar navbar-expand-md navbar-light" style="background:#ffc21c">
    <a href="#" class="navbar-brand">
    <img src="images/logo.svg" height="28" alt="{{config('app.name', 'Application')}}">
    </a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse" style="color:white;">
        <div class="navbar-nav">
            <a href="#" class="nav-item nav-link active">Home</a>
            <a href="#" class="nav-item nav-link">Profile</a>
            <a href="#" class="nav-item nav-link">Messages</a>
        </div>
        <div class="navbar-nav ml-auto">
            <a href="{{url('Home/login')}}" class="nav-item nav-link">Login</a>
        </div>
    </div>
</nav>