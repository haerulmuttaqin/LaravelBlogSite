<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::with('author', 'tags', 'category')->latest()->limit(10)->paginate(6),
        ]);
    }
}
