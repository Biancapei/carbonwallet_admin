<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('user')->latest()->paginate(10);
        return view('admin.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category' => 'nullable|string|in:carbon-accounting,hospitality,net-zero,regulations',
            'blog_status' => 'required|string|in:draft,published,deleted',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255'
        ]);

        $data = $request->only(['title', 'description', 'category', 'blog_status', 'content', 'is_published', 'meta_title', 'meta_description', 'meta_keywords']);
        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($request->title);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('blog-images', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        Blog::create($data);

        return redirect()->route('admin.index')->with('success', 'Blog post created successfully!');
    }

    public function edit($id)
    {
        try {
            $blog = Blog::findOrFail($id);
            return view('admin.edit', compact('blog'));
        } catch (\Exception $e) {
            abort(404, 'Blog post not found');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $blog = Blog::findOrFail($id);

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'category' => 'nullable|string|in:carbon-accounting,hospitality,net-zero,regulations',
                'blog_status' => 'required|string|in:draft,published,deleted',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_published' => 'boolean',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'meta_keywords' => 'nullable|string|max:255'
            ]);

            $data = $request->only(['title', 'description', 'category', 'blog_status', 'content', 'is_published', 'meta_title', 'meta_description', 'meta_keywords']);
            $data['slug'] = Str::slug($request->title);

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($blog->image) {
                    Storage::disk('public')->delete($blog->image);
                }

                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('blog-images', $imageName, 'public');
                $data['image'] = $imagePath;
            }

            $blog->update($data);

            return redirect()->route('admin.index')->with('success', 'Blog post updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.index')->with('error', 'Blog post not found or update failed.');
        }
    }

    public function destroy($id)
    {
        try {
            $blog = Blog::findOrFail($id);

            // Delete image if exists
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }

            $blog->delete();

            return redirect()->route('admin.index')->with('success', 'Blog post deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.index')->with('error', 'Blog post not found or deletion failed.');
        }
    }
}
