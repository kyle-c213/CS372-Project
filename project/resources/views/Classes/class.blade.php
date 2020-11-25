@extends('Layouts.app')

@section('title')
    {{$title ?? ''}}
@endsection

@if (session('status'))
    <div class="alert alert-success" role="alert">
       {{ session('status') }}                        
    </div>
@endif

<script>

    function getPost()
    {

    }

    function addClass()
    {
        var first_class = "{{auth()->class()->id}}";
        var second_class = "{{$class->id}}";
        var url = "{{route('class.addClass')}}";
        jQuery.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'POST',
            data: jQuery.param({
                class_name: class_name,
            }),
            dataType: false,
            cache: false,
            processData: false,      
            success: function(){
                alert('Success!');
                var c = document.getElementById("class");
                c.classList.remove("fa-class-plus");
                c.classList.add("fa-class-slash");
                c.parentElement.classList.add("text-danger");
                document.getElementById("classLink").removeEventListener("click", addClass);
                document.getElementById("classLink").addEventListener("click", removeClass);
                var contactsList = document.getElementById("classList");
                var li = document.createElement("li");
                var a = document.createElement("a");
                a.innerHTML = '{{\App\Models\Class::where('id', $class->id)->first()->name}}';
                a.href='{{route("class.show", $class->id)}}';
                li.appendChild(a);
                contactsList.appendChild(li);
            },
            error: function()
            {
                alert("Something went wrong");
            }
        });
    }

    function removeClass()
    {
        var class_name = "{{auth()->class()->id}}";
        var url = "{{route('class.removeClass')}}";

        jQuery.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: 'POST',
            data: jQuery.param({
                class_name: class_name,
            }),
            dataType: false,
            cache: false,
            processData: false,      
            success: function(){
                alert('Success!');
            },
            error: function()
            {
                alert("Something went wrong");
            }
        });
    }
</script>


@section('content')
    <div class="header">
    {{ __('Dashboard') }}
    </div>
    <div class="text-center top-page">
    <h1><strong>{{ $class->name }}</strong></h1>  <!--Placeholder for class name -->
        <h5 class="text-secondary font-italic">With Prof Name</h5> <!-- place holder for profs name-->
    </div>

    <div class="container" style="position:fixed;left:0">  <!-- Reminders on the right of the page-->
    <div class="row justify-content-left">
        <div class="text-left">
            <div class="card"style="width:200px;height:250px">
                <div class="card-header">{{__('Reminders')}}</div>
                    <div class="card-body">
                        <p>*Reminder 1</p><br>   <!--set todo list to connect -->
                        <p>*Reminder 2</p>
                    </div>
            </div>
        </div>
    </div>
</div>


<div class="container">  <!-- Place holder for posts -->
    <div class="row justify-content-center">
            <div class="card" style="width:400px">
                <div class="card-header">{{ __('UserName  Time /date') }}</div> <!-- User name and time of the post -->
                <div class="card-body"> 
                        <p> Post Content</p> 
                    </div>
            </div>
        </div>
    </div>

<br><br>

<div class="container">  <!-- Place holder for posts -->
    <div class="row justify-content-center">
            <div class="card" style="width:400px">
                <div class="card-header">{{ __('UserName  Time /date') }}</div> <!--  name and time of the post -->
                <div class="card-body">
                        <p> Post Content</p>
                    </div>
            </div>
        </div>
    </div>


        



<div class="fixed-bottom">  <!-- Submit a Post -->
    <div class="row justify-content-center">
        <form>
        <textarea id="Mpost" name ="Mpost" rows="4" cols="50">
            Create Post
            </textarea> 
            <br>
            <a class="btn btn-primary btn-lg" role="button">Post</a> 
            </form>
    </div>
</div>


<br><br><br><br><br><br>
<div class="container" style="position:fixed;bottom:25px">  <!-- Show Users who are in the class -->
    <div class="row justify-content-left">
        <div class="text-center">
            <div class="card"style="width:300px;height:100px">
                <div class="card-header">{{__('Users in the Class')}}</div>
                    <div class="card-body">
                        <p>User1  User2  User3...</p>
                    </div>
            </div>
        </div>
    </div>
</div>


@endsection

<!-- Contacts menu on Right-->
@include('inc.contactsidebar')




