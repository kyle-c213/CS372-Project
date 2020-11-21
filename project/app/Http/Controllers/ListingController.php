<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\ListingTag;
use Image;

class ListingController extends Controller
{
    //
    public function index()
    {
        $listings = Listing::where('sold', false)->where('deleted', false)->orderBy("created_at", "desc")->get();
        return View("Listings.index", compact('listings'));
    }

    public function create()
    {
        return View("Listings\create");
    }

    public function create_post(Request $request)
    {
        // create new listing and save details from form
        $listing = new Listing();
        $listing->title = $request->title;
        $listing->price = str_replace("$", "", $request->price);
        $listing->description = $request->description;
        $listing->posted_by = auth()->user()->id;
        $listing->course_id = null;
        $listing->sold = false;
        $listing->deleted = false;

        // for uploaded image
        if (request('picture'))
        {
            $picpath = request('picture')->store('listings', 'public');
            $pic = Image::make(public_path("storage/{$picpath}"))->fit(1000, 1000);
            $pic->save();

            $listing->picture = $picpath;
        }


        $listing->save();
        return redirect(route('listing.index'));
    }
}
