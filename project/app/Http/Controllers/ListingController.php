<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\ListingTag;

class ListingController extends Controller
{
    //
    public function index()
    {
        return View("listing.index");
    }

    public function create()
    {
        return View("Listings\create");
    }

    public function create_post()
    {
        
    }
}
