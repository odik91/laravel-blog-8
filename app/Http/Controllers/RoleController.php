<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "View Role";
        $roles = Role::orderBy('name', 'asc')->get();
        return view('admin.role.index', compact('title', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create Role';
        return view('admin.role.create', compact('title'));
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
            'name' => 'required|min:3|unique:roles'
        ]);

        $data = $request->all();

        Role::create($data);
        return redirect()->back()->with('message', "Role $request->name created succesfully");
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
        $title = 'Edit Role';
        $role = Role::find($id);
        return view('admin.role.edit', compact('title', 'role'));
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
            'name' => 'required|min:3|unique:roles,name,' . $id
        ]);

        $data = $request->all();
        $role = Role::find($id);
        $role->update($data);
        return redirect()->route('role.index')->with('message', "Role $request->name update succesfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::find($id)->delete();
        return redirect()->route('role.index')->with('message', "Role deleted succesfully");
    }

    public function trash() {
        $roles = Role::onlyTrashed()->get();
        $title = "Role Trash";
        return view('admin.role.trash', compact('roles', 'title'));
    }

    public function trashRestore($id) {
        Role::onlyTrashed()->where('id', $id)->restore();
        return redirect()->back()->with('message', "Role restore successfully");
    }

    public function trashRemove($id) {
        Role::onlyTrashed() ->where('id', $id)->forceDelete();
        return redirect()->back()->with('message', 'Role has gone forever');
    }
}
