<?php

namespace App\Http\Controllers;

use App\Models\ClassMember;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\ListingTag;
use App\Models\Mail;
use Image;

class ListingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // shows main listing page, all listings are displayed
    public function index()
    {
        $listings = Listing::where('sold', false)->where('deleted', false)->orderBy("created_at", "desc")->get();
        $numOfMessages = Mail::where('to', auth()->user()->id)->where('opened', false)->get()->count();
        return View("Listings.index", compact('listings'))->with('messages', $numOfMessages);
    }

    // listing create page, user can post to a class they have joined
    public function create()
    {
        $numOfMessages = Mail::where('to', auth()->user()->id)->where('opened', false)->get()->count();
        $member_of = ClassMember::where('user_id', auth()->user()->id)->get();
        return View("Listings\create", compact('member_of'))->with('messages', $numOfMessages);
    }

    // creates a listing
    public function create_post(Request $request)
    {
        // create new listing and save details from form
        $listing = new Listing();
        $listing->title = $request->title;

        // format pricing
        $price = str_replace("$", "", $request->price);
        $price = str_replace(",", "", $price);
        $listing->price = $price;
        
        $listing->description = $request->description == null ? "" : $request->description;

        $listing->posted_by = auth()->user()->id;
        if ($request->course != null)
        {
            $listing->course_id = $request->course;
        }
        $listing->sold = false;
        $listing->deleted = false;

        // for uploaded image
        if (request('picture'))
        {
            $picpath = request('picture')->store('listings', 'public');
            $pic = Image::make(public_path("storage/{$picpath}"));
            $pic->save();

            $listing->picture = $picpath;
        }

        // save listing and redirect to listing index page
        $listing->save();
        return redirect(route('listing.index'));
    }

    // shows listings made by a specific user
    public function show($user_id)
    {
        // all users made by specific user
        $listings = Listing::where('posted_by', $user_id)->where('sold', false)->where('deleted', false)->orderBy('created_at', "desc")->get();
        $numOfMessages = Mail::where('to', auth()->user()->id)->where('opened', false)->get()->count();
        
        return view('Listings.show', compact('listings'))->with('user_id', $user_id)->with('messages', $numOfMessages);
    }

    // user marks their listing as deleted
    public function delete($id)
    {
        $listing = Listing::findOrFail($id);
        if ($listing->posted_by == auth()->user()->id)
        {
            $listing->deleted = true;
            $listing->save();
        }
        return redirect(route("listing.show", $listing->posted_by));
    }

    // user marks their listing as sold
    public function sold($id)
    {
        $listing = Listing::findOrFail($id);
        if ($listing->posted_by == auth()->user()->id)
        {
            $listing->sold = true;
            $listing->save();
        }
        return redirect(route("listing.show", $listing->posted_by));
    }

    // shows a single listing, used for viewing a listing from a class
    public function details($listing_id)
    {
        $listing = Listing::findOrFail($listing_id);
        $numOfMessages = Mail::where('to', auth()->user()->id)->where('opened', false)->get()->count();
        return view('Listings.details', compact('listing'))->with('messages', $numOfMessages);
    }
}
