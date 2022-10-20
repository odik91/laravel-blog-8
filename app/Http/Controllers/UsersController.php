<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'View User';
        $users = User::orderBy('name', 'asc')->get();
        return view('admin.users.index', compact('title', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create User';
        return view('admin.users.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'username' => 'required|min:3|string|unique:users',
            'address' => 'min:3|string',
            'phone' => 'min:5|string',
            'image' => 'mimes:jpg,jpeg,png',
            'email' => 'required|string|regex:/(.+)@(.+)\.(.+)/i',
            'password' => 'required|string|min:5',
            'role' => 'required'
        ]);

        $data = $request->all();
        $image = '';

        if ($request->hasFile('image')) {
            $image = $request['image']->hashName();
            $request['image']->move(public_path('image/profile'), $image);
        }

        $data['image'] = $image;
        $data['role_id'] = $request['role'];
        $data['password'] = bcrypt($request['password']);
        $data['is_active'] = $request['options'];
        User::create($data);

        return redirect()->back()->with('message', "User $request->username registered succesfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $title = 'Edit User';
        return view('admin.users.edit', compact('user', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'username' => 'required|min:3|string|unique:users,email,' . $id,
            'address' => 'min:3|string',
            'phone' => 'min:5|string',
            'image' => 'mimes:jpg,jpeg,png',
            'email' => 'required|string|regex:/(.+)@(.+)\.(.+)/i',
            'role' => 'required'
        ]);

        $data = $request->all();
        $image = '';
        $user = User::find($id);
        $password = bcrypt($request['password']);

        if ($request->hasFile('image')) {
            if ($user['image'] != null) {
                unlink(public_path('image/profile' . '/' . $user['image']));
            }
            $image = $request['image']->hashName();
            $request['image']->move(public_path('image/profile'), $image);
        } else {
            $image = 'users.png';
        }

        if ($password != null) {
            $password = $user['password'];
        }

        $data['image'] = $image;
        $data['role_id'] = $request['role'];
        $data['password'] = $password;
        $data['is_active'] = $request['options'];
        
        $user->update($data);

        return redirect()->route('users.index')->with('message', "User $request->username updated succesfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')->with('message', "User deleted succesfully");
    }

    public function userTrash() {
        $users = User::onlyTrashed()->get();
        $title = "User Trash";
        return view('admin.users.trash', compact('users', 'title'));
    }

    public function trashRestore($id) {
        User::onlyTrashed()->where('id', $id)->restore();
        return redirect()->back()->with('message', "User has been restored");
    }

    public function destroyItem($id) {
        $user = User::onlyTrashed()->where('id', $id)->first();
        if(isset($user['image']) && ($user['image'] != null)) {
            unlink(public_path('image/profile' . '/' . $user['image']));
        }
        User::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect()->back()->with('message', "User has gone forever");
    }
}
