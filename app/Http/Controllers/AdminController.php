<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\DeletePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminController extends Controller
{
    public function show(): Response
    {
        $posts = Post::all();
        return Inertia::render('Admin/Dashboard', ['posts' => $posts]);
    }

    public function createPost(CreatePostRequest $request)
    {
        Post::updateOrCreate($request->validated());
        return redirect()->back()->with('status', 'Post created!');
    }

    public function deletePost(DeletePostRequest $request)
    {
        Post::destroy($request->validated());
        return redirect()->back()->with('status', 'Post deleted!');
    }
}
