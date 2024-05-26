<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PostEditor extends Controller
{
    public function show($uuid): Response
    {
        $post = Post::firstWhere('uuid', $uuid);
        return Inertia::render('Admin/PostEditor', ['post' => $post]);
    }
}
