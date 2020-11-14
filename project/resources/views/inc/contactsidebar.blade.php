<!-- Contacts sidebar -->

<nav id="contacts-sidebar" class="">
    <div class="card">
        <div class="card-header">
            <h2 class="">Contacts</h2>
        </div>
            <div class="card-body">
                <ul class="nav flex-column">
                    <li>
                        <button class="btn btn-primary btn-block" onclick="window.location.href='{{ route('chat') }}';">
                            Message Center</button>
                    </li>
                    <?php
                        $contacts = \App\Models\Contact::where('first_user', Auth::user()->id)->get();
                        $hasContacts = false;
                    ?>
                    @foreach($contacts as $key=>$val)
                        <?php
                            $hasContacts = true;
                            $contactName = \App\Models\User::where('id', $val->second_user)->first()->name;
                            
                        ?>
                        <li>
                            <a>{{$contactName}}</a>
                            <span class="fas fa-comment"></span>
                        </li>
                    @endforeach
                    @if($hasContacts == false)
                    <li>
                        You have no contacts!
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>

{{-- <nav id="contacts-sidebar" class="card col-md-4 d-md-block bg-light contacts-sidebar collapse">
        <div class="sidebar-sticky pt-3">
            <h2 class="card-header">Contacts</h2>
            <ul class="nav flex-column">
                <!-- CONTACTS ARE EXAMPLES, could not implement actual contacts, no database -->
                <li class="contact">
                    <img src="" alt="">
                    <a class="nav-link active nav-side-item" href="#">
                        Bob
                    </a>
                </li>
                <li class="contact">
                    <img src="" alt="">
                    <a class="nav-link active nav-side-item" href="#">
                        Joe
                    </a>
                </li>
                <li class="contact">
                    <img src="" alt="">
                    <a class="nav-link active nav-side-item" href="#">
                        Katy
                    </a>
                </li>
            </ul>
        </div>
</nav> --}}
