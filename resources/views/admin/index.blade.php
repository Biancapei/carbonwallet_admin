@extends('admin.layout')

@section('content')
<div>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="font-size: 24px; font-weight: bold; color: #374151; margin: 0;">Blog Management</h1>
        <a href="{{ route('admin.create') }}" class="create-new-post-btn" onmouseover="this.style.background='#16d3ca'" onmouseout="this.style.background='#000'">
            Create New Post
        </a>
    </div>

    @if($blogs->count() > 0)
                <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <div style="overflow-x: auto;">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blogs as $blog)
                                    <tr>
                                        <td>
                                            @if($blog->image)
                                                <img class="blog-image" src="{{ $blog->image_url }}" alt="{{ $blog->title }}">
                                            @else
                                                <div style="width: 50px; height: 50px; background: #f3f4f6; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-image" style="color: #9ca3af;"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div style="font-weight: 500; color: #374151;">
                                                {{ $blog->title }}
                                            </div>
                                        </td>
                                        <td>
                                            @if($blog->is_published)
                                                <span class="status-published">Published</span>
                                            @else
                                                <span class="status-draft">Draft</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="actions" style="display: flex; gap: 10px;">
                                                <a href="{{ route('admin.edit', $blog->id) }}" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('admin.destroy', $blog->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this blog post?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

            @if($blogs->hasPages())
                <div style="padding: 15px; border-top: 1px solid #e5e7eb;">
                    {{ $blogs->links() }}
                </div>
            @endif
        </div>
    @else
        <div style="text-align: center; padding: 60px 20px;">
            <h3 style="font-size: 18px; font-weight: 600; color: #374151; margin-bottom: 8px;">No blog posts</h3>
            <p style="color: #6b7280; margin-bottom: 24px;">Get started by creating a new blog post.</p>
                Create your first blog post
            </a>
        </div>
    @endif
</div>
@endsection
