@extends('Layouts.app')
<?php
  
?>
<script>
    //listens for when there has been a change in the professor seach bar
    var pSearch = document.getElementById("Psearchbar").addEventListener("keyup", profResult, false);
    //listens for a selected professor
    //var pFound = document.getElementById().addEventListener();

    function profResult(pSearch){
        var display = document.getElementById(profDisplay);
        var hidden = document.getElementById(submitted).value;

        //checks to see what is inthe search bar and displays the appropriate list of professors
        if(hidden == 0 || PSearch.value == null || PSearch.value == ""){
            //display all the professors, default option
            hidden = 0; //resets the hidden value when the search bar is cleared
        } /*else if (prof return = null){ //displays if the database has no profs to display
        }*/
        else{
            //display the profs related to the search
            hidden = 1; //updates the hidden value when something is entered in to the search bar

        }
    }

    /*blank to display profs OR show all then narrow(onchnage clear and re-display)*/
</script>

<!--Main body content-->
@section('content')
    <div class="container " id="body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div name="PSearch" class="container">
                    <form name="profSearch" id="profSearch" action="search.blade.php" method="POST">
                        <h5>Search a Professor to Rate</h5><br>
                        <input type="hidden" name="submitted" id="submitted" value="0">
                        <input type="text" name="Psearchbar" id="Psearchbar" placeholder="Search for a professor here" style=" width: 200px;" onkeyup="profResult">
                        <input type="submit" value="Search" style="width: 70px;">
                    </form>
                </div>
                <div name="PResult" class="container">
                    <h5>Current Results</h5>
                    <!--list of all profs to start, once searched list is reduced, says not profs found-->
                    <div>
                        <p id="profDisplay"> go to
                            <buton class="btn btn-primary btn-block" style="width: 150px;" onclick="window.location.href='/profRate/rate/1';">
                            <span class="fas" style="color:white;"></span>Rate Professor {{ $prof->name ?? ' '}}</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
