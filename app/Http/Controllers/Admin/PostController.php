<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\SubCategory;
use DOMDocument;
use Illuminate\Support\Str;
// use Image;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "View Post";
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('admin.post.index', compact('title', 'posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create Post';
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.post.create', compact('title', 'categories'));
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
            'title' => 'required|min:3',
            'category' => 'required',
            'subcategory' => 'required',
            'picture' => 'mimes:jpg,jpeg,png',
            'article' => 'required|min:10',
            'publish' => 'required',
        ]);

        $content = $request['article'];
        $dom = new \DOMDocument();
        $dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | libxml_use_internal_errors(true));
        $imageFiles = $dom->getElementsByTagName('img');
        $arrImg = [];
        foreach ($imageFiles as $key => $imageFile) {
            $data = $imageFile->getAttribute('src');
            if (strpos($data, ';') === false) {
                continue;
            }
            list($type, $data) = explode(';', $data);
            list($e, $data) = explode(',', $data);
            $imageData[$key] = base64_decode($data);
            $uniqueName = date_timestamp_get(date_create());
            $imageName[$key] = date('timestamp') . time() . $uniqueName . $imageFiles[$key]->getAttribute('data-filename');
            $path = public_path() . '/image/post-image/' . $imageName[$key];
            file_put_contents($path, $imageData[$key]);
            $imageFile->removeAttribute('src');
            $imageFile->setAttribute('src', '/image/post-image/'. $imageName[$key]);
            array_push($arrImg, $imageName[$key]);
        }

        $content = $dom->saveHTML();

        $image = '';

        if ($request->hasFile('picture')) {
            /**
             * mage require to install composer require intervention/image
             * then configure config/app.php
             * in provier add code in the bottom 
             * Intervention\Image\ImageServiceProvider::class
             * 
             * add code in the bottom of aliases
             * 'Image' => Intervention\Image\Facades\Image::class
             */
            $image = time() . $request['picture']->hashName();
            $pathImage = public_path('/image/post-image');
            $resizeImage = Image::make($request['picture']->path());
            $resizeImage->resize(1024, 1024, function ($const) {
                $const->aspectRatio();
            })->save($pathImage . '/' . $image);
        }

        $data = [
            'title' => ($request['title']),
            'slug' => Str::slug(strtolower($request['title'])),
            'category_id' => $request['category'],
            'sub_category_id' => $request['subcategory'],
            'content' => $content,
            'image' => $image,
            'author' => auth()->user()->id,
            'publish' => $request['publish'],
            'year' => date("Y"),
            'month' => date("m"),
        ];

        $create = Post::create($data);

        if ($create) {
            $post = Post::where('title', $request['title'])->first();
            for ($i = 0; $i < sizeof($arrImg); $i++) {
                $list['image_name'] = $arrImg[$i];
                $list['unique_post_id'] = $post['id'];
                PostImage::create($list);
            }
            return redirect()->route('posts.index')->with('message', "Post $request->title created successfully");
        } else {
            for ($i = 0; $i < sizeof($arrImg); $i++) {
                unlink(public_path("image/post-image/{$arrImg[$i]}"));
            }
            return redirect()->route('posts.index')->with('message', "Post $request->title fail to add");
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
        $post = Post::find($id);
        $title = "View Post";

        return view('admin.post.view', compact('post', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $title = 'Edit ' . $post['title'];
        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.post.edit', compact('post', 'title', 'categories'));
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
            'title' => 'required|min:3|unique:posts,title,' . $id,
            'category' => 'required',
            'subcategory' => 'required',
            'picture' => 'mimes:jpg,jpeg,png',
            'article' => 'required|min:10',
            'publish' => 'required'
        ]);

        $post = Post::find($id);
        $oldContent = $post['content'];

        $domOldArticle = new \DOMDocument();
        $domOldArticle->loadHTML($oldContent, LIBXML_HTML_NOIMPLIED | libxml_use_internal_errors(true));
        $findImages = $domOldArticle->getElementsByTagName('img');
        $oldImages = [];

        foreach ($findImages as $key => $findImage) {
            $data = $findImage->getAttribute('src');
            $data = explode('/', $data);
            array_push($oldImages, $data[3]);
        }

        $content = $request['article'];
        $dom = new \DOMDocument();
        $dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | libxml_use_internal_errors(true));
        $imageFiles = $dom->getElementsByTagName('img');
        $arrayImage = [];

        foreach ($imageFiles as $key => $imageFile) {
            $data = $imageFile->getAttribute('src');
            if (strpos($data, ';') === false) {
                continue;
            }
            list($type, $data) = explode(';', $data);
            list($e, $data) = explode(',', $data);
            $imageData[$key] = base64_decode($data);
            $uniqueName = date_timestamp_get(date_create());
            $imageName[$key] = date('timestamp') . time() . $key . $uniqueName . $imageFiles[$key]->getAttribute('data-filename');
            $path = public_path() . "/image/post-image/" . $imageName[$key];
            file_put_contents($path, $imageData[$key]);
            $imageFile->removeAttribute('src');
            $imageFile->setAttribute('src', '/image/post-image/'. $imageName[$key]);
            array_push($arrayImage, $imageName[$key]);
        }

        $content = $dom->saveHTML();

        // check if image is not used in post
        $checkNewImage =  new \DOMDocument();
        $checkNewImage->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | libxml_use_internal_errors(true));
        $newImages = $dom->getElementsByTagName('img');
        $newArrayImages = [];
        foreach ($newImages as $key => $newImage) {
            $data = $newImage->getAttribute('src');
            $data = explode('/', $data);
            if (isset($data[3])) {
                $name = $data[3];
                array_push($newArrayImages, $name);
            } else {
                array_push($newArrayImages, $data[0]);
            }
        }

        $image = $post['image'];

        if ($request->hasFile('picture')) {
            unlink(public_path("image/post-image/{$post['image']}"));
            $image = time() . $request['picture']->hashName();
            $pathImage = public_path('/image/post-image');
            $resizeImage = Image::make($request['picture']->path());
            $resizeImage->resize(1024, 1024, function ($const) {
                $const->aspectRatio();
            })->save($pathImage . '/' . $image);
        }

        $data = [
            'title' => ($request['title']),
            'slug' => Str::slug(strtolower($request['title'])),
            'category_id' => $request['category'],
            'sub_category_id' => $request['subcategory'],
            'content' => $content,
            'image' => $image,
            'author' => auth()->user()->id,
            'publish' => $request['publish'],
        ];

        $update = $post->update($data);

        if ($update) {
            $post = Post::where('title', $request['title'])->first();
            for ($i = 0; $i < sizeof($arrayImage); $i++) {
                $list['image_name'] = $arrayImage[$i];
                $list['unique_post_id'] = $post['id'];
                PostImage::create($list);
            }

            $arrayRemoveimage = array_diff($oldImages, $newArrayImages);
            $arrayRemoveimage = implode("/", $arrayRemoveimage);
            $arrayRemoveimage = explode("/", $arrayRemoveimage);
            if (sizeof($arrayRemoveimage) > 0) {
                for ($i = 0; $i < sizeof($arrayRemoveimage); $i++) {
                    if ($arrayRemoveimage[$i] != "") {
                        PostImage::where('image_name', $arrayRemoveimage[$i]);
                        unlink(public_path("image/post-image/{$arrayRemoveimage[$i]}"));
                    }
                }
            }
            return redirect()->route('posts.index')->with('message', "Post $request->title updated successfully");
        } else {
            return redirect()->route('posts.index')->with('message', "Post $request->title fail to update");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::find($id)->delete();
        return redirect()->back()->with('message', 'Post moved to trash');
    }

    public function loadSubcategory(Request $request, $id)
    {
        $subcategory = SubCategory::where('category_id', $id)->pluck('subname', 'id');
        return response()->json($subcategory);
    }

    public function ajaxUploadImage(Request $request)
    {
        $this->validate($request, [
            'image' => 'mimes:jpeg,jpg,png'
        ]);
        // return $request['image']->hashName();
        // dd($request['image']);
        $imageName = $request['image']->hashName();
        $request->image->move(public_path('post'), $imageName);
        // return "/post/$imageName";
        return asset("post/$imageName");
    }

    public function ajaxDeleteImage(Request $request)
    {
        $src = $request['src'];
        $charln = strlen($request['src']);
        $pathln = strlen(public_path('post')) - 7;
        $file_name = substr($request['src'], $pathln);
        // return $file_name;
        if (unlink(public_path("post/{$file_name}"))) {
            return 'image deleted';
        } else {
            return 'somethinng went wrong';
        }
    }

    public function trash()
    {
        $title = "Post trash";
        $posts = Post::onlyTrashed()->get();
        return view('admin.post.trash', compact('title', 'posts'));
    }

    public function trashRestore($id)
    {
        $posts = Post::onlyTrashed()->where('id', $id)->get();
        $title = '';
        foreach ($posts as $post) {
            $title = $post['title'];
        }
        Post::onlyTrashed()->where('id', $id)->restore();
        return redirect()->back()->with('message', "Post restore $title successfully");
    }

    public function destroyItem($id)
    {
        $posts = Post::onlyTrashed()->where('id', $id)->get();
        $image = '';
        foreach ($posts as $post) {
            $image = $post['image'];
        }
        unlink(public_path("post/{$image}"));
        Post::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect()->back()->with('message', 'Post has gone forever 😭');
    }

    public function uploadImage(Request $request)
    {
        $this->validate($request, [
            'image' => 'mimes:jpeg,jpg,png'
        ]); 
        $imageName = $request['image']->hashName(); 

        return Response()->json($imageName);
    }

    public function ajaxTest(Request $request)
    {
        $output = $request['testajax'];
        return response()->json($output);
    }
}
