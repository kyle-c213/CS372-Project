@extends('Layouts.app')

<script>
    function profResult(){
        var display = document.getElementById(profDisplay);
    }

    /*blank to display profs OR show all then narrow(onchnage clear and re-display)*/
</script>

<!--Left Sidebar-->
@include('inc.sidebar')

<!--Main body content-->
@section('content')
    <div class="container " id="body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div name="PSearch" class="container">
                    <form name="profSearch" id="profSearch" action="search.blade.php" method="POST">
                        <h5>Search a Professor to Rate</h5><br>
                        <input type="hidden" name="submitted" id="submitted" value="1">
                        <input type="text" name="Psearchbar" id="Psearchbar" placeholder="Search for a professor here" style=" width: 200px;" onkeyup="profResult">
                        <input type="submit" value="Search" style="width: 70px;">
                    </form>
                </div>
                <div name="PResult" class="container">
                    <h5>Current Results</h5>
                    <!--list of all profs to start, once searched list is reduced, says not profs found-->
                    <p id="profDisplay"> </p>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Contacts menu on Right-->
@include('inc.contactsidebar')
