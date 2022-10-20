<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Comment;
use App\Models\ReplayComment;
use App\Models\Message;

use function GuzzleHttp\Promise\all;

class BlogingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Home";
        return view('bloging.pages.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'msg' => ['required', 'min:3'],
            'name' => 'required|min:3',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
        ]);

        $data = [
            'name' => $request['name'],
            'email' => $request['email'],
            'comment' => $request['msg'],
            'post_id' => $request['postId']
        ];

        Comment::create($data);
        return redirect()->back()->with('message', 'Your comment has been added');
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
        //
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
        //
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

    public function singlePage($slug) {
        $post = Post::where('slug', $slug)->first();
        $title = 'View ' . $post['title'];
        if ($post['views'] != null) {
            $updated = Post::find($post['id']);
            $updated->views = $post['views'] + 1;
            $updated->save();
        } elseif ($post['views'] == "") {
            $updated = Post::find($post['id']);
            $updated->views = 1;
            $updated->save();
        }
        return view('bloging.pages.post_detail', compact('post', 'title'));
    }

    public function postByCategory($slug) {
        $category = Category::where('slug', $slug)->first();
        $postCategories = Post::where('category_id', $category['id'])->orderBy('created_at', 'desc')->limit(7)->get();
        $title = 'View list article ';
        $id = $category['id'];
        
        return view('bloging.pages.category_post', compact('category' ,'postCategories', 'title', 'id'));
    }

    public function postBySubategory($id) {
        $posts = Post::where('sub_category_id', $id)->orderBy('created_at', 'desc')->get();
        $title = '';
        foreach ($posts as $post) {
            $title = $post->getSubcategory['subname'];
        }
        
        return view('bloging.pages.subcategory_post', compact('posts', 'title'));
    }

    public function loadArticleData(Request $request) {
        $input = $request->all();        
        if (ceil(count(Post::all()) / 7) >= ceil($request['limit'] / 7)) {
            $data = Post::orderBy('created_at', 'desc')->offset($input['offset'])->limit(7)->get();
            $output = [];
            foreach ($data as $item) {
                array_push($output, [
                    "author" => $item->getUser['name'],
                    "category" => $item->getCategory['name'],
                    "content" => strip_tags(substr($item['content'], 0, 150)),
                    // "created_at" => substr($item['created_at'], 0, (strlen($item['created_at']) - 8)),
                    "created_at" => date_format(date_create(substr($item['created_at'], 0, (strlen($item['created_at']) - 9))), "D, d M Y"),
                    "image" => $item['image'],
                    "slug" => $item['slug'],
                    "subcategory" => $item->getSubcategory['subname'],
                    "title" => $item['title']
                ]);
            }
            return response()->json($output);
        } else {
            return;
        }                
    }

    public function loadArticleCategory(Request $request) {
        $input = $request->all();
        if (ceil(count(Post::where('category_id', $request['category'])->get()) / 7) >= ceil($request['limit'] / 7)) {
            $data = Post::where('category_id', $request['category'])->orderBy('created_at', 'desc')->offset($input['offset'])->limit(7)->get();
            $output = [];
            foreach ($data as $item) {
                array_push($output, [
                    "author" => $item->getUser['name'],
                    "category" => $item->getCategory['name'],
                    "content" => strip_tags(substr($item['content'], 0, 150)),
                    // "created_at" => substr($item['created_at'], 0, (strlen($item['created_at']) - 8)),
                    "created_at" => date_format(date_create(substr($item['created_at'], 0, (strlen($item['created_at']) - 9))), "D, d M Y"),
                    "image" => $item['image'],
                    "slug" => $item['slug'],
                    "subcategory" => $item->getSubcategory['subname'],
                    "title" => $item['title']
                ]);
            }
            return response()->json($output);
        }
    }

    public function postArchive($year, $month) {
        $posts = Post::where('year', $year)->where('month', $month)->orderBy('created_at', 'desc')->limit(7)->get();
        $title = 'Posts archive';
        $archive = date_format(date_create("$year-$month-15"),"F Y");
        $count = count(Post::where('year', $year)->where('month', $month)->orderBy('created_at', 'desc')->get());
        $year = $year;
        $month = $month;
        
        return view('bloging.pages.post_archive', compact('posts' ,'title', 'archive', 'count', 'year', 'month'));
    }

    public function loadPostArchive(Request $request) {
        $input = $request->all();
        if (ceil($request['limit'] / 7) <= ceil(count(Post::where('year', $request['year'])->where('month', $request['month'])->orderBy('created_at', 'desc')->get()) / 7)) {
            $data = Post::where('year', $request['year'])->where('month', $request['month'])->orderBy('created_at', 'desc')->offset($input['offset'])->limit(7)->get(); 
            $output = [];
            foreach ($data as $item) {
                array_push($output, [
                    "author" => $item->getUser['name'],
                    "category" => $item->getCategory['name'],
                    "title" => $item['title'],
                    "content" => strip_tags(substr($item['content'], 0, 150)),
                    "created_at" => date_format(date_create(substr($item['created_at'], 0, (strlen($item['created_at']) - 9))), "D, d M Y"),
                    // "created_at" => substr($item['created_at'], 0, (strlen($item['created_at']) - 8)),
                    "image" => $item['image'],
                    "slug" => $item['slug'],
                    "subcategory" => $item->getSubcategory['subname'],
                ]);
            }
            return response()->json($output);
        }
    }

    public function postReplay(Request $request) {
        $this->validate($request, [
            'replay' => ['required', 'min:3'],
            'name' => 'required|min:3',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i'
        ]);

        $data = [
            'comment_id' => $request['commentId'],
            'name' => $request['name'],
            'email' => $request['email'],
            'replay' => $request['replay']
        ];

        ReplayComment::create($data);
        return redirect()->back()->with('message', 'Comment has been submited');
    }

    public function searchQuery(Request $request) {

        $results = Post::where('title', 'like', "%$request->search%")->orWhere('slug', 'like', "%$request->search%")->orWhere('content', 'like', "%$request->search%")->paginate(10);
        $title = "Search Result";

        return view('bloging.pages.search', compact('results', 'title'));
    }

    public function about() {
        $title = "About Us";

        return view('bloging.pages.about', compact('title'));
    }

    public function contact() {
        $title = "Contact Us";
        return view('bloging.pages.contact', compact('title'));
    }

    public function sendMessage(Request $request) {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'subject' => 'required|min:3',
            'msg' => 'required|min:3'
        ]);

        $data = [
            'name' => $request['name'],
            'email' => $request['email'],
            'subject' => $request['subject'],
            'to' => 'staff',
            'message' => $request['msg']
        ];

        Message::create($data);
        return redirect()->back()->with('message', "Your message has been sent");
    }

    public function testView()
    {
        $firstResults = Post::offset(12)->limit(6)->get();
        $secondResults = Post::offset(18)->limit(6)->get();

        $items1 = [];
        $items2 = [];

        $allItems = [];
        
        $i = 1;
        foreach ($firstResults as $firstResult) {
            array_push($items1, [
                'num_1' => $i,
                'desc1' => $firstResult['title']
            ]);
            $i++;
        }

        foreach ($secondResults as $secondResult) {
            array_push($items2, [
                'num_2' => $i,
                'desc2' => $secondResult['title']
            ]);
            $i++;
        }

        $allItems = [$items1, $items2];
        // dd($allItems);
        return view('bloging.pages.test-view', compact('allItems'));
    }
}
