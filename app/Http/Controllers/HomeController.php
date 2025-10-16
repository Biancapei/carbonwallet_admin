<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class HomeController extends Controller
{
    public function index()
    {
        $blogs = Blog::published()->with('user')->latest()->take(6)->get();
        return view('home', compact('blogs'));
    }

    public function show(Blog $blog)
    {
        // Make sure the blog is published
        if (!$blog->is_published) {
            abort(404);
        }

        // Load related blog posts (excluding current one)
        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->with('user')
            ->latest()
            ->take(3)
            ->get();

        return view('article', compact('blog', 'relatedBlogs'));
    }
}
