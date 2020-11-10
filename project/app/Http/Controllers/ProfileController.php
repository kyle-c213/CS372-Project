<?php

namespace App\Http\Controllers;

use Image;
use Illuminate\Http\Request;
use \App\Models\User;

class ProfileController extends Controller
{
    public function show($user_id)
    {
        $user = User::findOrFail($user_id);
        return view('profiles.index', compact('user'));
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
