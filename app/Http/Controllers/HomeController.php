<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller {
    public function show(Request $request): Response {
        $posts = Post::where('public', 1)
            ->orderBy('category', 'ASC', 'created_at', 'DESC')
            ->get();
        $categories_map = [];
        $filter_category = $request->category;

        foreach ($posts as $post) {
            if (
                ($filter_category && $post->category != $filter_category) ||
                (!$filter_category && isset($categories_map[$post->category]) && sizeof($categories_map[$post->category]) > 2)
            )
                continue;
            if ($post->feature_image)
                $post->feature_image = Storage::url($post->feature_image);

            if (!in_array($post->category, array_keys($categories_map))) {
                $categories_map[$post->category] = [$post];
            } else {
                array_push($categories_map[$post->category], $post);
            }
        }
        $categories = [];
        foreach ($categories_map as $category => $posts) {
            array_push($categories, ['name' => $category, 'posts' => $posts]);
        }

        return Inertia::render('Home', ['posts_by_categories' => $categories, 'category' => $filter_category]);
    }

    public function viewPost($uuid): Response {
        $post = Post::select(['title', 'category', 'created_at', 'contents_html', 'feature_image'])->where(['uuid' => $uuid])->first();
        if ($post->feature_image)
            $post->feature_image = Storage::url($post->feature_image);
        return Inertia::render('ViewPost', ['post' => $post]);
    }
}
