@extends('layouts.app')

<script>
    // reads the uploaded image and displays on screen
function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#uploadedImage')
                        .attr('src', e.target.result)
                        .width(200)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
function formatCurrency()
{
    var price = $("#price").val();
    price = Number(price);
    $("#price").val("$" + price.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
}


function check(event){

    var title = document.getElementById("title").value;
    var price = document.getElementById("price").value;
    var errorCount = 0;

    //checks that a title is entered
    if(title == "" || title == null) {
        errorAlert = document.getElementById("titleError");
        errorAlert.innerHTML = "Please enter an ad title";
        errorCount++;
        event.preventDefault();
    } else {
        errorAlert = document.getElementById("titleError");
        errorAlert.innerHTML = "";
    }

    //checks that a price is entered
    if(price == "" || price == null) {
        errorAlert = document.getElementById("priceError");
        errorAlert.innerHTML = "Please enter a price";
        errorCount++;
        event.preventDefault();
    } else {
        errorAlert = document.getElementById("priceError");
        errorAlert.innerHTML = "";
        return;
    }
    return;
}
</script>

@section('content')

    <button class="btn btn-dark p-2 btn-block" onclick="window.location.href='{{route('listing.index')}}';">View All Listings</button>
    <button class="btn btn-secondary p-2 btn-block" onclick="window.location.href='{{route('mail.index')}}';">View Your Inbox ({{$messages}})</button>
    <br/>

    <div class="card">
        <div class="card-header">
            <h2>What are you selling?</h2>
        </div>
        <div class="card-body">
            <div class="form-group">
                <form id="sale" action="{{route('listing.create_post')}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label class="">Ad Title</label>
                        <input id="title" class="form-control col-sm-6" type="text" name="title"/>
                        <p class="text-danger" id="titleError"></p>
                    </div>
                    <div class="form-group">
                        <label class="">Price</label>
                        <input id="price" class="form-control col-md-2" type="text" name="price" onchange="formatCurrency()"/>
                        <p class="text-danger" id="priceError"></p>
                    </div>
                    <div class="form-group">
                        <label>Describe your item here</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <select name="course" class="form-control col-md-6">
                            <option value="">Select a class (optional)</option>
                            @foreach($member_of as $m)
                                <?php 
                                    $class = \App\Models\Course::where('id', $m->course_id)->first();
                                ?>
                                <option value="{{$class->id}}">{{$class->class_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control col-md-6" id="picture" name="picture" onchange="readURL(this)">
                        <img id="uploadedImage" src="#" alt=""/>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Post" onclick="check(event)"/>
                </form>
            </div>
        </div>
    </div>

@endsection