@extends('Layouts.app')

@section('title')
    {{$title ?? ''}}
@endsection

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    function addContact()
    {
        var first_user = "{{auth()->user()->id}}";
        var second_user = "{{$user->id}}";
        var url = "{{route('contact.addContact')}}";

        jQuery.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'POST',
            data: jQuery.param({
                first_user: first_user,
                second_user: second_user
            }),
            dataType: false,
            cache: false,
            processData: false,      
            success: function(){
                alert('Success!');
                var c = document.getElementById("contact");
                c.classList.remove("fa-user-plus");
                c.classList.add("fa-user-slash");
                c.parentElement.classList.add("text-danger");
                document.getElementById("contact2").innerHTML = " Remove contact";

                document.getElementById("contactLink").removeEventListener("click", addContact);
                document.getElementById("contactLink").addEventListener("click", removeContact);

                var contactsList = document.getElementById("contactsList");

                // if no contacts, remove first list element in contacts
                // contactsList.removeChild(contactsList.getElementsByTagName('li')[0]);

                var li = document.createElement("li");
                var a = document.createElement("a");

                a.innerHTML = '{{\App\Models\User::where('id', $user->id)->first()->name}}';
                a.href='{{route("profile.show", $user->id)}}';

                li.appendChild(a);
                contactsList.appendChild(li);
            },
            error: function()
            {
                alert("Something went wrong");
            }
        });
    }

    function removeContact()
    {
        var first_user = "{{auth()->user()->id}}";
        var second_user = "{{$user->id}}";
        var url = "{{route('contact.removeContact')}}";

        jQuery.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'POST',
            data: jQuery.param({
                first_user: first_user,
                second_user: second_user
            }),
            dataType: false,
            cache: false,
            processData: false,      
            success: function(){
                alert('Success!');
                var c = document.getElementById("contact");
                c.classList.remove("fa-user-slash");
                c.classList.add("fa-user-plus");
                document.getElementById("contactLink").classList.remove("text-danger");

                document.getElementById("contactLink").removeEventListener("click", removeContact);
                document.getElementById("contactLink").addEventListener("click", addContact);

                document.getElementById("contact2").innerHTML = " Add to contacts";


                // get user name for current page
                var currUserName = "{{\App\Models\User::where('id', $user->id)->first()->name}}";
                // get contact list
                var ul = document.getElementById("contactsList");
                // list of all li's in ul
                var listItems = ul.childNodes;
                for (var i = 0; i < listItems.length; i++)
                {
                    if (listItems[i].firstElementChild != null && listItems[i].firstElementChild.innerHTML === currUserName)
                    {
                        ul.removeChild(listItems[i]);
                        break;
                    }
                }
            },
            error: function()
            {
                alert("Something went wrong");
            }
        });
    }
</script>

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-3 p-5">
            <img src="{{ asset('/storage/'.config('chatify.user_avatar.folder').'/'. \App\Models\User::where('id', $user->id)->first()->avatar) }}" alt="User picture" class="rounded-circle w-100">
        </div>
        <div class="col-9 pt-5 pl-2">
            <div class="d-flex justify-content-between align-items-baseline">
                <h1><strong>{{ $user->name }}</strong></h1>

                @can('update', $user->profile)
                    <a href="/profile/{{ $user->id }}/edit"><span class="fas fa-edit"></span> Edit Profile</a>                    
                @else
                    @if($isContact)                       
                        <a href="#" id="contactLink" class="text-danger"><span id="contact" class="fas fa-user-slash"></span><span id="contact2"> Remove contact</span></a>                
                        <script>document.getElementById("contactLink").addEventListener("click", removeContact);</script>
                    @else
                        <a href="#" id="contactLink"><span id="contact" class="fas fa-user-plus"></span><span id="contact2"> Add to contacts<span></a>
                        <script>document.getElementById("contactLink").addEventListener("click", addContact);</script>
                    @endif
                @endcan
            </div>               
            <div class="d-flex justify-content-between align-items-baseline">
                <h5> {{ $user->profile->major ?? 'No major' }}</h5>
                @can('update', $user->profile)
                    <a href="#" data-toggle="modal" data-target="#contactList"><span class="fas fa-user-friends"></span> View contacts</a>
                @endcan
            </div>
            <div>
                <h5> {{ $user->profile->school ?? 'N/A' }} </h5>
            </div>
            <div>
                <aside> {{ $user->profile->bio }} </aside>     
            </div>
        </div>    
    </div>

    <hr style="border-top: 1px solid black;margin-top: -10px;" >

    <div class="row">
        <div class="col-12 pl-3 pr-3">
            <div class="card card-index">
                <div class="card-header d-flex">
                    <h4 class="d-flex align-items-center">Recent Posts</h4>
                </div>
                <div class="card-body">
                    
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="contactList">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Contacts</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="userContacts" class="table table-borderless">         
                            @foreach($contacts as $key=>$val)
                            <?php
                                $c = \App\Models\User::where('id', $val->second_user)->first()->name;
                            ?>
                            <tr>
                                <td style="width:80%">{{$c}}</td>
                                <td><span class="fas fa-comment"></span></td>
                                <td><a href="#" onclick="removeContact()" class="text-danger"><span id="contactModal" class="fas fa-user-slash"></span><span id="contact2"></a></td>
                            </tr>
                            @endforeach                     
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection