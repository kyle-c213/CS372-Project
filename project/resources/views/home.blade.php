@extends('layouts.app')

<style>
    .container-fluid {
  display: flex;
}



.fixed-bottom-right {
    position: absolute;
    bottom: 0px;
    right: 0px; 
}

#showChat{

}

#chat:hover{
    color:rgb(189, 189, 189);
    cursor: pointer;
}

</style>



@if (session('status'))
    <div class="alert alert-success" role="alert">
       {{ session('status') }}                        
    </div>
@endif
<!--{{ __('You are logged in!') }}-->



@section('content')


<div class="container-fluid py-4">

    <div id="showChat" class="fixed-bottom-right" class="fa-4x">
        <span class="fa-stack fa-2x">
            <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <a id="chat" class="fas fa-comments fa-stack-1x fa-inverse" href="{{route('chat')}}" style="text-decoration: none;"></a>
          </span>
    </div>

    <div class="row-fluid">

    <div class="col">
        @include('inc.sidebar')
    </div>


        <div class="col col-md-8">
            <div class="card card-index">
                <div class="card-header">
                    <h4>Make a Post</h4>
                </div>
                <div class="card-body">
                        <form action="" method="post">
                            <textarea name="body" cols="40" rows="5" class="form-control"></textarea>
                            <label for="Classes">Choose a Class</label>
                            <select id="Classes" name="Classes">
                                <option value="All">All</option>
                                <option value="CS372">CS372</option>
                                <option value="CS340">CS340</option>
                                <option value="Placeholders...">Placeholders...</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-right">Share</button>
                        </form>
                    </div>  

                    <div class="card-header">
                        <h4>Updates from your classes</h4>
                   </div> 
                    <div class="card-body">
                        Content...
                    </div>        
                </div>
            </div>
        

        <div class="col">
            <!-- Contacts menu on Right-->
            @include('inc.contactsidebar')
        </div>
    </div>
</div>
</div>
@endsection

