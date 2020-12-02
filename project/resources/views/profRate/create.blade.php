@extends('layouts.app')

<script>

    function check(event){

        var name = document.getElementById("name").value;
        var faculty = document.getElementById("faculty").value;
        var errorCount = 0;
        
        //checks that a name is entered
        if(name == "" || name == null) {
            errorAlert = document.getElementById("nameError");
            errorAlert.innerHTML = "Please enter a name";
            errorCount++;
            event.preventDefault();
        } else {
            errorAlert = document.getElementById("nameError");
            errorAlert.innerHTML = "";
        }
        
        //checks that a faculty is entered
        if(faculty == "" || faculty == null) {
            errorAlert = document.getElementById("facultyError");
            errorAlert.innerHTML = "Please enter a faculty";
            errorCount++;
            event.preventDefault();
        } else {
            errorAlert = document.getElementById("facultyError");
            errorAlert.innerHTML = "";
            return;
        }
        return;
    }
</script>

<!-- Main body content-->
@section('content')
            <!--form to add new Professor-->
                <div name="PRate" class="card">
                    <div class="card-header">
                        <h3>Add A New Professor</h3>
                    </div>
                    <div class="card-body">
                        <form name="ratingSub" id="ratingSub" action="store" method="post" onsubmit='check(event)' enctype="multipart/form-data">
                            @csrf <!--verification that its from the rating page-->
                            <h5>You will be sent to the new professor's rating page once filled out</h5>
                            <p> Professor Name: <input type="text" name="name" id="name" class="form-control col-md-6"/><p id='nameError' style='color:red;'></p>
                            <p> Professor Faculty: <input type="text" name="faculty" id="faculty" class="form-control col-md-6"><p id='facultyError' style='color:red;'></p>
                            <p><input type="submit" value="Add Professor" class="btn btn-primary"></p>
                        </form>
                    </div>
                </div>
            <!--end of form--> 
@endsection
