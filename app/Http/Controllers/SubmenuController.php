<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submenus;

class SubmenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'View Submenu';
        $submenus = Submenus::get();
        return view('admin.submenu.index', compact('title', 'submenus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create Submenu';
        return view('admin.submenu.create', compact('title'));
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
            'menu_id' => 'required',
            'title' => 'required|min:3',
            'route' => 'required|min:3',
            'icon' => 'required',
            'active' => 'required'
        ]);

        $data = $request->all();
        Submenus::create($data);

        return redirect()->back()->with('message', "Submenu $request->title created successfully");
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
        $title = 'Edit Submenu';
        $submenu = Submenus::where('id', $id)->first();

        return view('admin.submenu.edit', compact('title', 'submenu'));
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
            'menu_id' => 'required',
            'title' => 'required|min:3',
            'route' => 'required|min:3',
            'icon' => 'required',
            'active' => 'required'
        ]);

        $submenu = Submenus::find($id);
        $data = $request->all();
        $submenu->update($data);

        return redirect()->route('submenu.index')->with('message', "Submenu $request->title updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Submenus::find($id)->delete();
        return redirect()->route('submenu.index')->with('message', "Submenu deleted successfully");
    }

    public function trash() {
        $title = 'Submenu Trash';
        $submenus = Submenus::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('admin.submenu.trash', compact('title', 'submenus'));
    }

    public function restoreSubmenu($id) {
        Submenus::onlyTrashed()->where('id', $id)->restore();
        return redirect()->back()->with('message', "Submenu has been restored");
    }

    public function deleteSubmenu($id) {
        $submenu = Submenus::onlyTrashed()->where('id', $id)->first();
        Submenus::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect()->back()->with('message', "Submenu $submenu->title has been deleted permanently");
    }
}
