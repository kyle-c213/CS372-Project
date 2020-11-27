<!-- Contacts sidebar -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>

    .addProf{

    }

    .addProf:hover{
        color: limegreen !important;
        cursor: pointer;
    }
</style>

<script>
    function searchUsers()
    {
        // $("#resultsList").empty();

        var searchString = $("#contactSearch").val();
        var url = "{{route('contact.search')}}";

        jQuery.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'POST',
            data: jQuery.param({
                searchString: searchString
            }),
            dataType: 'JSON',
            cache: false,
            processData: false,      
            success: function(data){
                if (data.emptyList == true)
                {
                    $("#resultsList").empty();
                }
                else
                {
                    // the list that holds results
                    var ul = document.getElementById("resultsList");

                    // list of all li's in ul
                    var listItems = ul.childNodes;

                    // a list of all names listed
                    var listedUsers = new Array();
                        
                    // a list of indexes in listedUsers that need to be removed
                    var removeAtIndexes = new Array();

                    // go through listed users
                    for (var j = 0; j < listItems.length; j++)
                    {
                        // if names is not present continue the loop
                        if (listItems[j].firstChild == null)
                        {
                            continue;
                        }
                        // if listed name is in return data
                        if (data.users.filter(x => x.name === listItems[j].firstChild.innerHTML).length > 0)
                        {
                            // do not remove from list, user is present in return data
                            // add to listed users array
                            listedUsers.push(listItems[j].firstChild.innerHTML); 
                        }
                        else
                        {
                            // user needs to be removed
                            removeAtIndexes.push(j);
                        }                                               
                    }

                    // remove users from list
                    for (var j = 0; j < removeAtIndexes.length; j++)
                    {
                        listItems[j].parentNode.removeChild(listItems[j]);
                    }

                    // go through returned data
                    for (var i = 0; i < data.users.length; i++)
                    {                       
                        var addToList;
                        
                        // if returned user is listed, do not add new element
                        // otherwise add to display
                        if (listedUsers.includes(data.users[i].name) == true)
                        {
                            addToList = false;
                        }
                        else{
                            addToList = true;
                        }

                        // the span element can be added later to add users as contacts from this list
                        if (addToList == true){
                            var li = document.createElement("li");
                            var a = document.createElement("a");
                            // var span = document.createElement("span");

                            a.innerHTML = data.users[i].name;
                            
                            a.href = "{{route('profile.show', ':id')}}";
                            a.href = a.href.replace(':id', data.users[i].id);
                            // span.classList.add("fas");
                            // span.classList.add("fa-user-plus");
                            // span.classList.add("float-right");
                            // span.classList.add("text-primary");
                            // span.classList.add("addProf");
                            li.appendChild(a);                     
                            // li.appendChild(span);
                            li.classList.add("bg-light");
                            li.classList.add("p-2");
                            ul.appendChild(li);
                        }                    
                    }
                }
            },
            error: function()
            {
            }
        });
    }
</script>

<nav id="contacts-sidebar" class="">
    <div class="card">
        <div class="card-header">
            <h2 class="">Contacts</h2>
        </div>
            <div class="card-body">
                <ul class="nav flex-column">                 
                    {{-- <li>
                        <button class="btn btn-primary btn-block" onclick="window.location.href='{{ route('chat') }}';">
                            Visit Message Center</button>
                    </li> --}}
                    <li>
                        <input id="contactSearch" onkeyup="searchUsers()" type="text" class="form-control" placeholder="Search for your friends" />
                    </li>
                </ul>
                <div class="searchResults">
                    <ul id="resultsList" class="nav flex-column">
                    </ul>
                </div>
                <ul class="nav flex-column" id="contactsList">
                    <?php
                        $contacts = \App\Models\Contact::where('first_user', Auth::user()->id)->get();
                        $hasContacts = false;
                    ?>
                    @foreach($contacts as $key=>$val)
                        <?php
                            $hasContacts = true;
                            $contactName = \App\Models\User::where('id', $val->second_user)->first()->name;
                        ?>
                        <li class="p-1">                           
                            <a href="{{route('profile.show', $val->second_user)}}">{{$contactName}}</a>
                            {{-- if we want to include images on contacts panel <img src="{{ asset('/storage/'.config('chatify.user_avatar.folder').'/'. \App\Models\User::where('id', $val->second_user)->first()->avatar) }}" class="rounded-circle float-right" style="width:25px;max-width:25px;"> --}}
                            {{-- <span class="fas fa-comment"></span> can be added later for quick messaging --}}
                        </li>
                    @endforeach
                    @if($hasContacts == false)
                    <li id="noContactsMessage">
                        No contacts yet!
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
