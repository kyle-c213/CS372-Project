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
                        <button class="btn btn-light btn-block" onclick="window.location.href='{{route('class.index')}}';">
                        <span class="fas fa-graduation-cap"></span> Classes
                        </button>
                    </li>
                    <li class="">
                        <button class="btn btn-light btn-block" onclick="window.location.href='{{route('profSearch.search')}}';">
                        <span class="fas fa-star"></span> Professor Ratings</button>
                    </li>
                    <li class="">
                        <button class="btn btn-light btn-block" onclick="window.location.href='{{route('listing.index')}}';">
                            <span class="fas fa-store"></span> Buy & Sell</button>
                    </li>
                    <li class="">
                        <button class="btn btn-light btn-block" onclick="window.location.href='{{route('todo')}}';">
                        <span class="fas fa-clipboard-list"></span> To Do
                        </button>
                    </li>
                </ul>
            </div>
            @yield('importantdates')
            @yield('classlistings')
        </div>
    </div>
</nav>
