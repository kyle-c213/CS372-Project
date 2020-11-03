@extends('layouts.app')

@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<?php
    $count = 0;
?>

<style>
    #add{
        color:green;
    }

    #add:hover{
        color: rgb(0, 172, 0);
        cursor: pointer;
    }

    .check{
        color:green;
    }

    .check:hover{
        color: rgb(0, 172, 0);
        cursor: pointer;
    }

    .refresh{
        color:green;
    }

    .refresh:hover{
        color: rgb(0, 172, 0);
        cursor: pointer;
    }
</style>

<script>
    var count = 0;
    // $(window).load(function(){
    //     count = "{{$count}}";
    // });

    function addTask(){
        let body = $("#body").val();
        var date = $("#datetime").val();

        var url = "{{route('addTask')}}";      

        jQuery.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'POST',
            data: jQuery.param({
                body: body,
                dateTime: date
            }),
            dataType: 'json',
            cache: false,
            processData: false,      
            success: function(response){
                // will add new task to top of to do list

                count++;
                

                // create new input field for body
                var newBodyInput = document.createElement("input");
                var newBodyId = document.createAttribute("id");
                var newBodyClass = document.createAttribute("class");
                var newBodyValue = document.createAttribute("value");
                var newBodyType = document.createAttribute("type");
                newBodyId.value = "body" + count;
                newBodyClass.value = "form-control";
                newBodyValue.value = body;
                newBodyType.value = "text";
                newBodyInput.setAttributeNode(newBodyId);
                newBodyInput.setAttributeNode(newBodyClass);
                newBodyInput.setAttributeNode(newBodyValue);
                newBodyInput.setAttributeNode(newBodyType);

                // create check
                var newCheck = document.createElement("span");
                var newCheckId = document.createAttribute("id");
                newCheckId.value = "check" + count;
                newCheck.setAttributeNode(newCheckId);
                newCheck.classList.add("fas");
                newCheck.classList.add("fa-check-square");
                newCheck.classList.add("fa-2x");
                newCheck.classList.add("align-middle");
                newCheck.classList.add("check");            

                // create date input field
                var newDateInput = document.createElement("input");
                var newDateId = document.createAttribute("id");
                var newDateClass = document.createAttribute("class");
                var newDateValue = document.createAttribute("value");
                var newDateType = document.createAttribute("type");
                newDateId.value = "datetime" + count;
                newDateClass.value = "form-control";
                newDateValue.value = date;
                newDateType.value = "text";
                newDateInput.setAttributeNode(newDateId);
                newDateInput.setAttributeNode(newDateClass);
                newDateInput.setAttributeNode(newDateValue);
                newDateInput.setAttributeNode(newDateType);
                newDateInput.classList.add("date");

                // create hidden field to hold task id
                var newHidden = document.createElement("input");
                var newHiddenId = document.createAttribute("id");
                var newHiddenValue = document.createAttribute("value");
                var newHiddenType = document.createAttribute("type");
                newHiddenId.value = "id" + count;
                newHiddenValue.value = response.id;
                newHiddenType.value = "hidden";
                newHidden.setAttributeNode(newHiddenId);
                newHidden.setAttributeNode(newHiddenValue);
                newHidden.setAttributeNode(newHiddenType);

                // add new task to the table
                let table = document.getElementById("tasklist");
                let row = table.insertRow(0);
                let cell1 = row.insertCell(0);
                let cell2 = row.insertCell(1);
                let cell3 = row.insertCell(2);
                cell1.appendChild(newCheck);
                cell2.appendChild(newBodyInput);
                cell3.appendChild(newDateInput);
                table.appendChild(newHidden);

                // event for completing task
                document.getElementById("check" + count).addEventListener("click", function(event){
                    completeTask(event, count);
                });

                document.getElementById("body" + count).addEventListener("change", function(){
                    updateBody(count);
                });

                document.getElementById("datetime" + count).addEventListener("change", function(){
                    updateDate(count);
                });
            },
            error: function()
            {
            }
        });       
    }

    function completeTask(event, count){
        var id = $("#id" + count).val();
        var url = "{{route('completeTask')}}";

        jQuery.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'POST',
            data: jQuery.param({
                id: id
            }),
            dataType: false,
            cache: false,
            processData: false,      
            success: function(){
                // remove from table
                var rowToRemove = event.target.parentElement.parentElement.rowIndex;
                document.getElementById("tasklist").deleteRow(rowToRemove);
            },
            error: function()
            {
                alert("Something went wrong");
            }
        });
}

    function updateBody(count){
        var id = $("#id" + count).val();
        var body = $("#body" + count).val();
        var url = "{{route('todo.updateBody')}}";

        jQuery.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'POST',
            data: jQuery.param({
                id: id,
                body: body
            }),
            dataType: false,
            cache: false,
            processData: false,      
            success: function(){
            },
            error: function()
            {
            }
        });
    }

    function updateDate(count){
        var id = $("#id" + count).val();
        var date = $("#datetime" + count).val();
        var url = "{{route('todo.updateDate')}}";

        jQuery.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'POST',
            data: jQuery.param({
                id: id,
                date: date
            }),
            dataType: false,
            cache: false,
            processData: false,      
            success: function(){
            },
            error: function()
            {
            }
        });
    }

    function refresh(){
        location.reload();
    }
</script>

<div class="container py-4">

    <h2>Your To-Do List <span class="refresh fas fa-sync" onclick="refresh()"></span></h2>
    
    <table class="table table-sm">
        <tr>
            <td style="width: 60%;"><input id="body" type="text" class="form-control" placeholder="Enter a new task" /></td>
            <td style="width: 20%"><input id="datetime" class="date form-control" type="text" placeholder="Date" /></td>
            <td style="width: 10%"><span id="add" class="fas fa-plus fa-2x align-middle" onclick="addTask()"></span></td>
        </tr>
    </table>

    <div class="card">
    <table id="tasklist" class="table table-borderless">            
        @foreach($todo as $key=>$val)
            <?php
                $tempdate = date('F d, Y', strtotime($val->due_date));
            ?>
            <tr>
                <td style="width: 2%"><span class="fas fa-check-square fa-2x align-middle check" onclick="completeTask(event, '{{$count}}')"></span></td>
                <td style="width: 60%;"><input id="body{{$count}}" type="text" class="form-control" value="{{$val->body}}" onchange="updateBody('{{$count}}')" /></td>
                <td style="width: 20%"><input id="datetime{{$count}}" class="date form-control" type="text" value="{{$tempdate}}" onchange="updateDate('{{$count}}')"/></td>
                <input type="hidden" value="{{$val->id}}" id="id{{$count}}"/>
            </tr>
            <?php $count++ ?>
            <script>count = {{$count}};</script>
        @endforeach
    </table>
    </div>
</div>

<script src="/js/moment.min.js"></script>
<script src="/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">

    $('.date').datepicker({  

       format: 'dd-mm-yyyy'

     });  

</script> 
    
@endsection