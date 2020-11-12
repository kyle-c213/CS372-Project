<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Contact;
use \App\Models\User;

class ContactController extends Controller
{
    //


    public function addContact(Request $request)
    {
        $contact = new Contact();
        $contact->first_user = $request->first_user;
        $contact->second_user = $request->second_user;
        $contact->save();
    }

    public function removeContact(Request $request)
    {
        $contact = Contact::where('first_user', $request->first_user)
                            -> where('second_user', $request->second_user)
                            ->delete();
        // $contact->delete();
    }
}
