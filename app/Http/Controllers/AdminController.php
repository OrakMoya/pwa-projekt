<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\DeletePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Storage;
use Str;

class AdminController extends Controller
{
    public function show(): Response
    {
        $posts = Post::orderBy('created_at', 'DESC')->get();
        foreach ($posts as $post) {
            if ($post->feature_image)
                $post->feature_image = Storage::url($post->feature_image);
        }
        return Inertia::render('Admin/Dashboard', ['posts' => $posts]);
    }

    public function createPost(CreatePostRequest $request)
    {
        $validated = $request->validated();
        $validated['uuid'] = Str::uuid();
        Post::updateOrCreate($validated);
        return redirect()->back()->with('status', 'Post created!');
    }

    public function deletePost(DeletePostRequest $request)
    {
        Post::destroy($request->validated());
        return redirect()->back()->with('status', 'Post deleted!');
    }

    public function savePost(UpdatePostRequest $request)
    {
        $validated = $request->validated();
        if (!$validated['contents_html']) {
            $validated['contents_html'] = '';
        }

        $post = Post::updateOrCreate(
            ['uuid' => $validated['uuid']],
            $validated
        );

        if ($request->file('feature_image')) {
            if ($post->feature_image && Storage::exists($post->feature_image)) {
                Storage::delete($post->feature_image);
            }
            $path = Storage::putFile('public/posts/' . $post->uuid, $request->file('feature_image'));
            $post->feature_image = $path;
            $post->save();
        }

        return redirect()->back()->with('status', 'Post saved!');
    }
}
