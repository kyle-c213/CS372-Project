@extends('layouts.app')

@section('title')
    {{$title ?? ''}}
@endsection

<!--Left Sidebar-->
@include('inc.sidebar')

<script>
    var cSearch = document.getElementById("Csearchbar").addEventListener("keyup", classResult, false);

    //var pFound = document.getElementById().addEventListener();
    function ClassResult(cSearch){
        var display = document.getElementById(classDisplay);
        var hidden = document.getElementById(submitted).value;

        if(hidden == 0 || CSearch.value == null || CSearch.value == ""){
            hidden = 0; 
        } else {
            hidden = 1;
        }
    }
</script>

<style>
    .addClass{
    }
    .addClass:hover{
        color: limegreen !important;
        cursor: pointer;
    }
</style>

<script>
    function searchClass()
    {
        // $("#resultsList").empty();
        var searchString = $("#classSearch").val();
        var url = "{{route('class.search')}}";
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
                    var listedClass = new Array();
                        
                    // a list of indexes in listedClass that need to be removed
                    var removeAtIndexes = new Array();
                    // go through listed Class
                    for (var j = 0; j < listItems.length; j++)
                    {
                        // if names is not present continue the loop
                        if (listItems[j].firstChild == null)
                        {
                            continue;
                        }
                        // if listed name is in return data
                        if (data.class.filter(x => x.name === listItems[j].firstChild.innerHTML).length > 0)
                        {
                            // do not remove from list, class is present in return data
                            // add to listed class array
                            listedClass.push(listItems[j].firstChild.innerHTML); 
                        }
                        else
                        {
                            // class needs to be removed
                            removeAtIndexes.push(j);
                        }                                               
                    }
                    // remove class from list
                    for (var j = 0; j < removeAtIndexes.length; j++)
                    {
                        listItems[j].parentNode.removeChild(listItems[j]);
                    }
                    // go through returned data
                    for (var i = 0; i < data.classes.length; i++)
                    {                       
                        var addToList;
                        
                        // if returned class is listed, do not add new element
                        // otherwise add to display
                        if (listedClass.includes(data.class[i].name) == true)
                        {
                            addToList = false;
                        }
                        else{
                            addToList = true;
                        }
                        // the span element can be added later to add class as contacts from this list
                        if (addToList == true){
                            var li = document.createElement("li");
                            var a = document.createElement("a");
                            // var span = document.createElement("span");
                            a.innerHTML = data.class[i].name;
                            
                            a.href = "{{route('class.show', ':id')}}";
                            a.href = a.href.replace(':id', data.class[i].id);
                            // span.classList.add("fas");
                            // span.classList.add("fa-class-plus");
                            // span.classList.add("float-right");
                            // span.classList.add("text-primary");
                            // span.classList.add("addContact");
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

<!--Main body content-->
<nav id="class-sidebar" class="">
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
                        <input id="contactSearch" onkeyup="searchClass()" type="text" class="form-control" placeholder="Search for your Classes" />
                    </li>
                </ul>
                <div class="searchResults">
                    <ul id="resultsList" class="nav flex-column">
                    </ul>
                </div>
                <ul class="nav flex-column" id="contactsList">
                    <?php
                        $contacts = \App\Models\Courses::where('first_class', Auth::class()->id)->get();
                        $hasClass = false;
                    ?>
                    @foreach($class as $key=>$val)
                        <?php
                            $hasClass = true;
                            $className = \App\Models\Courses::where('id', $val->second_class)->first()->class;
                        ?>
                        <li class="p-1">                           
                            <a href="{{route('class.show', $val->second_class)}}">{{$className}}</a>
                            {{-- <span class="fas fa-comment"></span>  --}}
                        </li>
                    @endforeach
                    @if($hasClass == false)
                    <li id="noClassMessage">
                        No classes yet!
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>
@endsection
<!-- Contacts menu on Right-->
@include('inc.contactsidebar')