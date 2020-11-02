@extends('layouts.app')

<style>
    .container {
  display: flex;
}

.item {
  height: 100px;
  width: 100px; /* A fixed width as the default */
}

.item-center { 
  flex-grow: 1; /* Set the middle element to grow and stretch */
}

.item + .item { 
  margin-left: 2%; 
}

</style>



@if (session('status'))
    <div class="alert alert-success" role="alert">
       {{ session('status') }}                        
    </div>
@endif
<!--{{ __('You are logged in!') }}-->



@section('content')


<div class="container py-4">

    <div class="row">

    <div class="col">
        <!-- Left sidebar-->
        @include('inc.sidebar')
    </div>

        <div class="col-md-8">
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
        

        <div class="col col-lg-12">
            <!-- Contacts menu on Right-->
            @include('inc.contactsidebar')
        </div>
    </div>
</div>
</div>
@endsection

