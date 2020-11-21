<!--Sidebar navigation-->

<style>
    li{
        margin:0 0 10px 0;
    }
    </style>

<nav id="sidebarMenu" class="">
    <div class="card">
            <div class="card-body text-center">
                <ul class="nav flex-column">
                    <li>
                        <button class="btn btn-primary btn-block" onclick="window.location.href='{{ url('home') }}';">
                            <span class="fas fa-home" style="color:white;"></span> Home</button>
                    </li>
                    <li>
                        <button class="btn btn-secondary btn-block" onclick="window.location.href='{{ url('chat') }}';">
                            <span class="fas fa-comments" style="color:white;"></span> Message Center</button>
                    </li>
                    <li class="">
                        <button class="btn btn-light btn-block" onclick="window.location.href='#';">
                        Buy & Sell</button>
                    </li>
                    <li class="">
                        <button class="btn btn-light btn-block" onclick="window.location.href='/profRate/';">
                        Professor Ratings</button>
                    </li>
                    <li class="">
                        <button class="btn btn-light btn-block" onclick="window.location.href='../Classes/classSearch.blade.php';">
                        Class search
                        </button>
                    </li>
                    <li class="">
                        <button class="btn btn-light btn-block" onclick="window.location.href='{{route('todo')}}';">
                        To Do
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

{{-- <nav id="sidebarMenu" class="col-md-4 d-md-block bg-light sidebar collapse">
    <div class="sidebar-sticky">
            <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active nav-side-item" href="#">
                Buy & Sell
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active nav-side-item" href="{{route('profSearch')}}">
                Ratings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active nav-side-item" href="../Classes/classSearch.blade.php">
                Class search
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active nav-side-item" href="#">
            <a class="nav-link active nav-side-item" href="{{route('todo')}}">
                To Do
                </a>
            </li>
            </ul>
        </div>
    </div>
</nav> --}}
