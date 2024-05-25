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
        $posts = Post::all();
        return Inertia::render('Home', ['posts' => $posts]);
    }
}
