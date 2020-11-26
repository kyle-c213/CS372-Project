@extends('Layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>

    .addContact{

    }

    .addContact:hover{
        color: limegreen !important;
        cursor: pointer;
    }
</style>

<script>
    function searchProf()
    {
        // $("#resultsList").empty();

        var searchString = $("#Psearchbar").val();
        var url = "{{route('profSearch.search')}}";

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
                    var listedProfs = new Array();
                        
                    // a list of indexes in listedProfs that need to be removed
                    var removeAtIndexes = new Array();

                    // go through listed Profs
                    for (var j = 0; j < listItems.length; j++)
                    {
                        // if names is not present continue the loop
                        if (listItems[j].firstChild == null)
                        {
                            continue;
                        }
                        // if listed name is in return data
                        if (data.professors.filter(x => x.name === listItems[j].firstChild.innerHTML).length > 0)
                        {
                            // do not remove from list, user is present in return data
                            // add to listed Profs array
                            listedProfs.push(listItems[j].firstChild.innerHTML); 
                        }
                        else
                        {
                            // user needs to be removed
                            removeAtIndexes.push(j);
                        }                                               
                    }

                    // remove Profs from list
                    for (var j = 0; j < removeAtIndexes.length; j++)
                    {
                        listItems[j].parentNode.removeChild(listItems[j]);
                    }

                    // go through returned data
                    for (var i = 0; i < data.professors.length; i++)
                    {                       
                        var addToList;
                        
                        // if returned user is listed, do not add new element
                        // otherwise add to display
                        if (listedProfs.includes(data.professors[i].name) == true)
                        {
                            addToList = false;
                        }
                        else{
                            addToList = true;
                        }

                        // the span element can be added later to add Profs as contacts from this list
                        if (addToList == true){
                            var li = document.createElement("li");
                            var a = document.createElement("a");
                            // var span = document.createElement("span");

                            a.innerHTML = data.professors[i].name;
                            
                            a.href = "{{route('profRate.show', ':id')}}";
                            a.href = a.href.replace(':id', data.professors[i].id);
                            // span.classList.add("fas");
                            // span.classList.add("fa-user-plus");
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
@section('content')
    <div class="container " id="body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div name="PSearch" class="container">
                    <h5>Search a Professor to Rate</h5>
                    <input type="text" name="Psearchbar" id="Psearchbar" style="display:inline-block; width: 200px;" placeholder="Search for a professor here" style=" width: 200px;" class="form-control" onkeyup="searchProf()">
                    <div style="display:inline-block;"><buton class="btn btn-primary btn-block" style="display:inline-block; width: 150px; color: white;" onclick="window.location.href='{{route('profSearch.create')}}';">Add a Professor</button></div>
                    <br><br>
                </div>
                <div name="PResult" class="container">
                    <h5>Current Results</h5>
                    <!--list of all profs to start, once searched list is reduced, says not profs found-->
                    <div id="profDisplay">
                        <lu id="resultsList" class="nav flex-column">
                        </lu>
                        <buton class="btn btn-primary btn-block" style="width: 150px;" onclick="window.location.href='(route('profRate.show',$prof->id)}}">
                        <span class="fas" style="color:white;"></span>Rate Professor {{ $prof->name ?? ' '}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
