<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $title = 'View Menu';
        $menus = Menu::orderBy('id', 'asc')->get();
        return view('admin.menu.index', compact('title', 'menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create Menu';
        return view('admin.menu.create', compact('title'));
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
            'menu' => 'required|min:3|unique:menus',
            'icon' => 'required|min:5'
        ]);
        
        $route = $request['route'];
        if ($route == null) {
            $route = 'none';
        }
        
        $data = $request->all();
        $data['route'] = $route;
        Menu::create($data);

        return redirect()->back()->with('message', "Menu <b>$request->menu</b> created successfully");
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
        $menu = Menu::where('id', $id)->first();
        $title = 'Edit Menu';
        return view('admin.menu.edit', compact('menu', 'title'));
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
            'menu' => 'required|min:3|unique:menus,icon,' . $id,
            'icon' => 'required|min:5'
        ]);
        
        $route = $request['route'];
        if ($route == null) {
            $route = 'none';
        }

        $menu = Menu::find($id);
        $data = $request->all();
        $data['route'] = $route;
        $menu->update($data);

        return redirect()->route('menu.index')->with('message', "Menu <b>$request->menu</b> updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Menu::find($id)->delete();
        return redirect()->route('menu.index')->with('message', 'Menu deleted succesfully');
    }

    public function trash() {
        $title = 'Menu Trash'; 
        $menus = Menu::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return view('admin.menu.trash', compact('title', 'menus'));
    }

    public function restoreMenu($id) {
        Menu::onlyTrashed()->where('id', $id)->restore();
        return redirect()->back()->with('message', 'Menu restored successfully');
    }

    public function delete($id) {
        $menu = Menu::onlyTrashed()->where('id', $id)->first();
        Menu::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect()->back()->with('message', "Menu $menu->menu has gone forever");
    }
}
