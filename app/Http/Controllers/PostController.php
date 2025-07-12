<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function create(): Response
    {
        if(!Auth::check()) {
            abort(403);
        }

        return Inertia::render('Posts/Create');
    }

    public function store(Request $request)
    {
        if(!Auth::check()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);

        $post = new Post();
        $post->title = $validated['title'];
        $post->slug = $validated['slug'];
        $post->description = $validated['description'];
        $post->user_id = Auth::id();
        
        if($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $post->image = $path;
        }

        $post->save();

        return redirect()->route('dashboard')->with('success', 'Post created successfully');
    }


    public function show(Post $post): Response
    {
        return Inertia::render('Posts/Show', [
            'post' => $post->load('author'),
        ]);
    }

    public function edit(Post $post): Response
    {
        return Inertia::render('Posts/Edit', [
            'post' => $post,
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);

        $post->title = $validated['title'];
        $post->slug = $validated['slug'];
        $post->description = $validated['description'];
        
        if($request->hasFile('image')) {
            if($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $path = $request->file('image')->store('posts', 'public');
            $post->image = $path;
        }

        $post->save();

        return redirect()->route('dashboard')->with('success', 'Post updated successfully');
    }
}
