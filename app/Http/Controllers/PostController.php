<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Category;
use App\Models\postview;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        //retriving from database correct eloquent method
        $posts = Post::where('active', '=', '1')
            ->orderBy('published_at', 'desc')
            ->paginate(4);
        return view('home', ['posts' => $posts]);
        
        // return view('home', ['posts' => $posts]);
        // $posts= Post::queryb ()
        // ->where('active', '=', '1')
        // ->whereDate('published_at', '<', Carbon::now())
        // ->orderBy('published_at', 'desc')
        // ->paginate();
        // return view('home', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post, Request $request)
    {
         // //Check if post is active  before publish
        if(!$post->active){
            throw new NotFoundResourceException();
        }
        //IMPEMENTING NEXT
        $next = Post::query()
        ->where('active', '=', 1)
        //->whereDate('published_at', '<=', Carbon::now())
        ->whereDate('published_at', '<', $post->published_at)
        ->orderBy('published_at', 'desc')
        ->limit(1)
        ->first();

        //Implimenting Previous
        $prev = Post::query()
        ->where('active', '=', 1)
        //->whereDate('published_at', '<=', Carbon::now())
        ->whereDate('published_at', '>', $post->published_at)
        ->orderBy('published_at', 'asc')
        ->limit(1)
        ->first();

        $user= $request->user();
        postview::create([
            'ip_adress' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'post_id' => $post->id,
            'user_id' => $user?->id,
        ]);

        return view('post.show', compact('post', 'prev', 'next'));

    }
    //selecting by category
    public function byCategory(Category $category){
        $posts = Post::query()
            ->join('category_post', 'posts.id', '=', 'category_post.post_id')
            ->where('category_post.category_id', '=', $category->id)
            ->where('active', '=', true)
            ->whereDate('published_at', '<=', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->paginate(10);

            return view('post.category', compact('posts', 'category'));
    }

    
    
}
