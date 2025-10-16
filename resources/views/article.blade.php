<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $blog->title }} - {{ config('app.name', 'CarbonAI') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @php
        $assets = \App\Helpers\AssetHelper::getViteAssets();
    @endphp
    @if($assets['css'] && $assets['js'])
        <link rel="stylesheet" href="{{ $assets['css'] }}">
        <script src="{{ $assets['js'] }}"></script>
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link rel="stylesheet" href="{{ app()->environment('production') ? secure_asset('css/style.css') : asset('css/style.css') }}">
</head>
<body style="background-color: #000;">
    <!-- Navigation -->
    <nav>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                        CarbonAI Admin
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.index') }}" class="text-[#1b1b18] dark:text-[#EDEDEC] hover:text-[#dc2626] transition-colors">
                        Admin
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Article Content -->
    <div class="article-container">
        <a href="{{ route('home') }}" class="back-button">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Home
        </a>

        <article>
            <header class="article-header">
                <div class="article-meta">
                    <span>{{ $blog->created_at->format('M d, Y') }}</span>
                </div>

                <h1 class="article-title">{{ $blog->title }}</h1>

                @if($blog->description)
                    <p class="article-description">{{ $blog->description }}</p>
                @endif
            </header>

            @if($blog->image)
                <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" class="article-image">
            @endif

            <div class="article-content">
                {!! nl2br($blog->content) !!}
            </div>
        </article>

        @if($relatedBlogs->count() > 0)
            <section class="related-posts">
                <h3>Related Articles</h3>
                <div class="related-grid">
                    @foreach($relatedBlogs as $relatedBlog)
                        <div class="related-card">
                            @if($relatedBlog->image)
                                <img src="{{ $relatedBlog->image_url }}" alt="{{ $relatedBlog->title }}">
                            @endif
                            <div class="related-card-content">
                                <h4>{{ $relatedBlog->title }}</h4>
                                @if($relatedBlog->description)
                                    <p>{{ Str::limit($relatedBlog->description, 100) }}</p>
                                @endif
                                <a href="{{ route('article.show', $relatedBlog) }}" class="read-more">
                                    Read More →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</body>
</html>
