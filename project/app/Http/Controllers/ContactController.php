<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use \App\Models\Contact;
use \App\Models\User;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // adds user as a contact
    public function addContact(Request $request)
    {
        $contact = new Contact();
        $contact->first_user = $request->first_user;
        $contact->second_user = $request->second_user;
        $contact->save();
    }

    // removes user as a contact
    public function removeContact(Request $request)
    {
        $contact = Contact::where('first_user', $request->first_user)
                            -> where('second_user', $request->second_user)
                            ->delete();
    }

    // for the contacts search bar in right nav bar
    // return users that match search
    public function search(Request $request)
    {
        if ($request['searchString'] == null || $request['searchString'] == "")
        {
            return response()->json(array('emptyList' => true), 200);
        }
        $searchString = trim(filter_var($request['searchString'], FILTER_SANITIZE_STRING));
        $records = User::select('name', 'id')->where('name', 'LIKE', "%{$searchString}%")
                ->where('id', '!=', auth()->user()->id)->take(10)->get();

        // if there are results
        if ($records->count() > 0)
        {
            return response()->json(array('users' => $records), 200);
        }
    }

    // go to email page, not used as of right now
    public function email($user_id)
    {
        $user = User::findOrFail($user_id);
        return view('Contacts.email', compact('user'));
    }
}
