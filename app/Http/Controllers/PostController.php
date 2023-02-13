<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Post::query();
        $query->where('user_id', $user->id);
        if ($request->search) {
            $query->where('title', 'like', "%$request->search%");
            // Find owned posts
        }
        $posts = $query->get();
        return view('posts.index', [ 'posts' => $posts ]);
    }

    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post = new Post([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'user_id' => $user->id,
        ]);

        $post->save();
        return redirect('/posts')->with('success', 'Post has been added');
    }

    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post = Post::find($id);
        $post->title = $request->get('title');
        $post->body = $request->get('body');
        $post->is_public = $request->get('is_public');
        $post->save();

        return redirect('/posts')->with('success', 'Post has been updated');
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();

        return redirect('/posts')->with('success', 'Post has been deleted Successfully');
    }

    public function publicize($id)
    {
        $post = Post::find($id);
        $post->is_public = $post->is_public ? 0 : 1;
        $post->save();

        return redirect('/posts')->with('success', 'Post has been updated');
    }
}
