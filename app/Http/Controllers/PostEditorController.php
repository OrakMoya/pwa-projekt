<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Storage;

class PostEditorController extends Controller
{
    public function show($uuid): Response|RedirectResponse
    {
        $post = Post::firstWhere('uuid', $uuid);
        if ($post->read_only) return redirect('/admin/posts')->withErrors(['post' => 'This post is read only!']);
        if ($post->feature_image)
            $post->feature_image = Storage::url($post->feature_image);
        return Inertia::render('Admin/PostEditor', ['post' => $post]);
    }
}
