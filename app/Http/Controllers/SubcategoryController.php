<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'View Subcategory';
        $subcategories = SubCategory::orderBy('subname', 'asc')->get();
        return view('admin.subcategory.index', compact('title', 'subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create Subcategory';
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.subcategory.create', compact('title', 'categories'));
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
            'category' => 'required',
            'subname' => 'required|unique:sub_categories'
        ]);

        // $data = $request->all();
        $data['category_id'] = $request['category'];
        $data['subname'] = $request['subname'];
        $data['slug'] = Str::slug($request['subname']);

        SubCategory::create($data);

        return redirect()->back()->with('message', "Subcategory <b>$request->subname</b> created successfully");
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
        $subcategory = SubCategory::find($id);
        $categories = Category::orderBy('name', 'asc')->get();
        $title = 'Edit subcategory ' . strtolower($subcategory['subname']);
        return view('admin.subcategory.edit', compact('title', 'subcategory', 'categories'));
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
            'category' => 'required',
            'subname' => 'required|unique:sub_categories'
        ]);

        // $data = $request->all();
        $subcategory = SubCategory::find($id);
        $data['category_id'] = $request['category'];
        $data['subname'] = $request['subname'];
        $data['slug'] = Str::slug($request['subname']);

        $subcategory->update($data);

        return redirect()->route('subcategories.index')->with('message', "Subcategory <b>$request->subname</b> updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategory = SubCategory::find($id);
        $subcategory->delete();
        return redirect()->route('subcategories.index')->with('message', "Subcategory $subcategory->subname has moved to trash");
    }

    public function trash() {
        $subcategories = SubCategory::onlyTrashed()->get();
        $title = 'Subcategory Trash';
        return view('admin.subcategory.trash', compact('subcategories', 'title'));
    }

    public function trashRestore($id) {
        SubCategory::onlyTrashed()->where('id', $id)->restore();
        return redirect()->back()->with('message', "Subcategory has been restore");
    }

    public function destroyItem($id) {
        SubCategory::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect()->back()->with('message', "Subcategory gone forever");
    }
}
