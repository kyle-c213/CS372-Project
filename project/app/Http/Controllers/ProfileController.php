<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use \App\Models\User;
use \App\Models\Contact;

class ProfileController extends Controller
{
    public function show($user_id)
    {
        $user = User::findOrFail($user_id);

        // check current users contacts
        $curr_user = auth()->user()->id;
        $contacts = \App\Models\Contact::where('first_user', $curr_user)
                                        ->where('second_user', $user_id)
                                        ->first();
        
        $contactExists = $contacts == null ? false : true; 
        
        $userContacts = \App\Models\Contact::where('first_user', $curr_user)
                                            ->get();

        return view('profiles.index', compact('user'))->with('isContact', $contactExists)->with('contacts', $userContacts);
    }

    public function edit($user_id)
    {
        $user = User::findOrFail($user_id);
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }

    public function update($user_id)
    {
        $user = User::findOrFail($user_id);
        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'major' => '',
            'school' => '',
            'bio' => '',
            'picture' => '',
        ]);

        //if request has a picture, update path
        if(request('picture'))
        {
            $picpath = request('picture')->store('profile', 'public');
            $pic = Image::make(public_path("storage/{$picpath}"))->fit(1000, 1000);
            $pic->save();

            $picArr = ['picture' => $picpath ];
        }

        auth()->user()->profile->update(array_merge($data, $picArr ?? []));

        return redirect("/profile/{$user_id}");
    }
}
