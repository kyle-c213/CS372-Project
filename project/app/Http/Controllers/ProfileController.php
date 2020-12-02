<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use \App\Models\User;
use \App\Models\Contact;
use \App\Models\ClassMember;
use Illuminate\Support\Facades\Auth;
use Chatify\Facades\ChatifyMessenger as Chatify;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

    public function update(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);
        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'major' => '',
            'school' => '',
            'bio' => '',
            'picture' => '',
        ]);

        if ($request->hasFile('picture')) {
            // allowed extensions
            $allowed_images = Chatify::getAllowedImages();

            $file = $request->file('picture');
            // if size less than 150MB
            if ($file->getSize() < 150000000) {
                if (in_array($file->getClientOriginalExtension(), $allowed_images)) {
                    // delete the older one
                    if (Auth::user()->avatar != config('chatify.user_avatar.default')) {
                        $path = storage_path('app/public/' . config('chatify.user_avatar.folder') . '/' . Auth::user()->avatar);
                        if (file_exists($path)) {
                            @unlink($path);
                        }
                    }
                    // upload
                    $avatar = Str::uuid() . "." . $file->getClientOriginalExtension();
                    $update = User::where('id', Auth::user()->id)->update(['avatar' => $avatar]);
                    $file->storeAs("public/" . config('chatify.user_avatar.folder'), $avatar);
                    $success = $update ? 1 : 0;
                } else {
                    $msg = "File extension not allowed!";
                    $error = 1;
                }
            } else {
                $msg = "File extension not allowed!";
                $error = 1;
            }
        }

        auth()->user()->profile->update(array_merge($data, $picArr ?? []));

        return redirect("/profile/{$user_id}");
    }
}
