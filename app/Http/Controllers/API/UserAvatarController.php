<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class UserAvatarController extends Controller
{
    public function store()
    {
    	request()->validate(['avatar' => 'required|image']);

    	auth()->user()->update([
    		'avatar_path' => request()->file('avatar')->store('avatars', 'public')
    	]);

    	return response(['success' => 'Avatar Uploaded'], 204);
    }
}
