<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\{Tag, Category, Post};
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(
            ['index', 'show']
        );
    }

    public function index()
    {
        return view('posts.index', [
            'posts' => Post::latest()->paginate(6),
        ]);
    }

    public function show(Post $post)
    {
        $posts = Post::where('category_id', $post->category_id)->latest()->limit(6)->get();
        return view('posts.show', compact('post', 'posts'));
    }

    public function create()
    {
        return view('posts.create', [
            'post' => new Post(),
            'categories' => Category::get(),
            'tags' => Tag::get(),
        ]);
    }

     // @php-ignore
    public function store(PostRequest $request)
    {
        $request->validate([
            'tumbnail' => 'image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $entity = $request->all();
        
        $slug = Str::slug(request('title'));
        $entity['slug'] = $slug;
       
        $thumbnail = request()->file('thumbnail') ? request()->file('thumbnail')->store('images/posts') : null;
        
        $entity['category_id'] = request('category');
        $entity['thumbnail'] = $thumbnail;

        $post = Auth::user()->posts()->create($entity);
        $post->tags()->attach(request('tags'));

        session()->flash('success', 'The post was created');
        return redirect('posts');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post,
            'categories' => Category::get(),
            'tags' => Tag::get()
        ]);
    }

    public function update(PostRequest $request, Post $post)
    {
        $request->validate([
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $this->authorize('update', $post);
        
        if (request()->file('thumbnail')) {
            Storage::delete($post->thumbnail);
            $thumbnail =  request()->file('thumbnail')->store('images/posts');
        } else {
            $thumbnail =  $post->thumbnail;
        }

        $entity = $request->all();
        $entity['category_id'] = request('category');
        $entity['thumbnail'] = $thumbnail;
        $post->update($entity);
        $post->tags()->sync(request('tags'));

        session()->flash('success', 'The post was updated');
        return redirect('posts');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        Storage::delete($post->thumbnail);
        $post->tags()->detach();
        $post->delete();
        
        session()->flash('success', 'The post was deleted');
        return redirect('posts');
    }
}
