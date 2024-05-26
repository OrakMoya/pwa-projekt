<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function show(): Response
    {
        $posts = Post::where('public', 1)
            ->orderBy('date_created')->get();
        return Inertia::render('Home', ['posts' => $posts]);
    }

    public function viewPost($uuid)
    {
        $post = Post::select(['title', 'category', 'created_at', 'contents_html'])->where(['uuid' => $uuid])->first();
        return Inertia::render('ViewPost', ['post' => $post]);
    }
}
