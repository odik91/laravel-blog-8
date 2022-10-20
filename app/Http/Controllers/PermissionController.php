<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'View Permission';
        $permissions = Permission::get();

        return view('admin.permission.index', compact('title', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create Permission';
        return view('admin.permission.create', compact('title'));
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
            'role_id' => 'required|unique:permissions'
        ]);

        $menu_id = '';

        if (sizeof($request['enable']) > 0) {
            for ($i = 0; $i < sizeof($request['enable']); $i++) {
                if ($i == sizeof($request['enable']) - 1) {
                    $menu_id .= $request['enable'][$i];
                } else {
                    $menu_id .= $request['enable'][$i] . ',';
                }
            }
        }

        $data['role_id'] = $request['role_id'];
        $data['menu_id'] = $menu_id;
        $data['name'] = $request['name'];

        $create = Permission::create($data);

        if ($create) {
            return redirect()->back()->with('message', 'Permission created successfully');
        } else {
            return redirect()->back()->with('message', 'Permission not created');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'View Permission';
        $permission = Permission::where('id', $id)->first();
        $id = $id;

        return view('admin.permission.view', compact('title', 'permission', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Edit Permission';
        $permission = Permission::where('id', $id)->first();

        return view('admin.permission.edit', compact('title', 'permission'));
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
            'role_id' => 'required|unique:permissions,menu_id,' . $id,
        ]);
        
        $menu_id = '';
        if (sizeof($request['enable']) > 0) {
            for ($i = 0; $i < sizeof($request['enable']); $i++) {
                if ($i == sizeof($request['enable']) - 1) {
                    $menu_id .= $request['enable'][$i];
                } else {
                    $menu_id .= $request['enable'][$i] . ',';
                }
            }
        }

        $permission = Permission::find($id);
        $data['role_id'] = $request['role_id'];
        $data['menu_id'] = $menu_id;
        $data['name'] = $request['name'];
        $permission->update($data);

        return redirect()->route('permission.index')->with('message', 'Permission updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
