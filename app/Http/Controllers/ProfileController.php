<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index() {
        $title = 'View Profile';
        return view('admin.profile.index', compact('title'));
    }

    public function edit($id) {
        $title = 'Edit Profile';
        $data = User::where('id', $id)->first();
        return view('admin.profile.edit', compact('title', 'data'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'email' => 'required|email:rfc,dns',
            'address' => 'required|min:5'
        ]);

        $data = $request->all();
        $image = auth()->user()->image;
        $user = User::find($id);

        if($request->hasFile('image')) {
            if (auth()->user()->image != 'users.png' && auth()->user()->image != null) {
                // unlink('image/profile/' . auth()->user()->image);
                unlink(public_path('image/profile' . '/' . auth()->user()->image));
            }
            $image = $request['image']->hashName();
            $request['image']->move(public_path('image/profile'), $image);
        }

        $data['image'] = $image;
        $user->update($data);
        
        return redirect()->route('profile.index')->with('message', 'Profile updated successfully');
    }
}
