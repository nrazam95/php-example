<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostPublicController extends Controller
{
    public function index(Request $request)
    {
        // Log::debug('foo');
        $query = Post::query();
        $query->where('is_public', true);
        if ($request->search) {
            $query->where('title', 'like', "%$request->search%");
            // $query->orWhere('is_public', true);
        }
        $posts = $query->get();
        return view('post-publics.index', [ 'posts' => $posts ]);
    }

    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show', compact('post'));
    }
}
