<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('front.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,'.Auth::id(),
            'password' => 'nullable|confirmed|min:6',
        ]);

        $user = $request->user();
        $user->email = $request->email;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate(['photo' => 'required|image|max:2048']);
        $user = Auth::user();

        if ($user->photo) {
            Storage::delete($user->photo);
        }

        $path = $request->file('photo')->store('photos', 'public');
        $user->photo = $path;
        $user->save();

        return back();
    }

    public function deletePhoto()
    {
        $user = Auth::user();
        if ($user->photo) {
            Storage::delete($user->photo);
            $user->photo = null;
            $user->save();
        }

        return response()->json(['success' => true]);
    }
}
