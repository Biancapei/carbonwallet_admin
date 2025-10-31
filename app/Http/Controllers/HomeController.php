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

    public function blogs()
    {
        $blogs = Blog::published()->with('user')->latest()->paginate(4);

        // Get blogs filtered by category for each tab
        $carbonAccountingBlogs = Blog::published()->with('user')->where('category', 'carbon-accounting')->latest()->get();
        $hospitalityBlogs = Blog::published()->with('user')->where('category', 'hospitality')->latest()->get();
        $netZeroBlogs = Blog::published()->with('user')->where('category', 'net-zero')->latest()->get();
        $regulationsBlogs = Blog::published()->with('user')->where('category', 'regulations')->latest()->get();

        return view('blog', compact('blogs', 'carbonAccountingBlogs', 'hospitalityBlogs', 'netZeroBlogs', 'regulationsBlogs'));
    }
}
