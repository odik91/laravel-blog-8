<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $title = 'View Category';
        return view('admin.category.index', compact('title', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create Category';
        return view('admin.category.create', compact('title'));
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
            'description' => 'required|min:3',
            'image' => 'mimes:jpg,jpeg,png'
        ]);

        $data = $request->all();
        $image = 'default.png';

        if ($request->hasFile('image')) {
            $image = $request['image']->hashName();
            $request['image']->move(public_path('image'), $image);
        }

        $data['image'] = $image;
        $data['slug'] = Str::slug($request['name']);        
        Category::create($data);

        return redirect()->back()->with('message', "Category $request->name created successfully");
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
        $category = Category::find($id);
        $title = 'Edit ' . $category['name'];
        return view('admin.category.edit', compact('category', 'title'));
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
            'description' => 'required|min:3',
            'image' => 'mimes:jpg,jpeg,png'
        ]);

        $data = $request->all();
        $category = Category::find($id);
        $image = $category['image'];

        if ($request->hasFile('image')) {
            unlink(public_path("image/" . $category->image));
            $image = $request['image']->hashName();
            $request['image']->move(public_path('image'), $image);
        }

        $data['image'] = $image;
        $data['slug'] = Str::slug($request['name']);
        $category->update($data);

        return redirect()->route('categories.index')->with('message', "Category $request->name updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::find($id)->delete();
        return redirect()->back()->with('message', "Category deleted successfully");
    }

    public function trash() {
        $categories = Category::onlyTrashed()->get();
        $title = 'Category Trash';
        return view('admin.category.trash', compact('title', 'categories')); 
    }

    public function trashRestore($id) {
        Category::onlyTrashed()->where('id', $id)->restore();
        return redirect()->route('categories.index')->with('message', "Category restore successfully");
    }

    public function destroyItem($id) {
        Category::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect()->back()->with('message', "Category gone forever");
    }
}
