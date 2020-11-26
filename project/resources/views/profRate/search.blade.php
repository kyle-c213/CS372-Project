@extends('Layouts.app')

<!--Main body content-->
@section('content')
    <div class="container " id="body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div name="PSearch" class="container">
                    <h5>Search a Professor to Rate</h5><br>
                    <span>
                    <form name="profSearch" id="profSearch" action="search.blade.php" method="POST" style="display:inline-block;">    
                        <input type="hidden" name="submitted" id="submitted" value="0">
                        <input type="text" name="Psearchbar" id="Psearchbar" placeholder="Search for a professor here" style=" width: 200px;" onkeyup="profResult">
                        <input type="submit" value="Search" style="width: 70px;">
                    </form>
                    <div style="display:inline-block;"><buton class="btn btn-primary btn-block" style="width: 150px; color: white;" onclick="window.location.href='{{route('profSearch.create')}}';">Add a Professor</button><br></div>
                    </span>
                </div>
                <div name="PResult" class="container">
                    <h5>Current Results</h5>
                    <!--list of all profs to start, once searched list is reduced, says not profs found-->
                    <div>
                        <p id="profDisplay">
                           
                            <buton class="btn btn-primary btn-block" style="width: 150px;" onclick="window.location.href='(route('profRate.show',$prof->id)}}">
                            <span class="fas" style="color:white;"></span>Rate Professor {{ $prof->name ?? ' '}}</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
