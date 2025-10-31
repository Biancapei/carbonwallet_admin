<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blogs - {{ config('app.name', 'CarbonAI') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
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
    <link rel="stylesheet" href="{{ app()->environment('production') ? secure_asset('css/blogs.css') : asset('css/blogs.css') }}">
    <!-- Prevent scroll to top on pagination -->
    <script>
        if (window.location.search.includes('page=')) {
            window.addEventListener('beforeunload', function() {
                localStorage.setItem('scrollAfterPagination', 'true');
            });
        }
    </script>
</head>
<body style="background-color: #000;">
    <!-- Navigation -->
    <nav>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                        {{ config('app.name', 'CarbonAI') }}
                    </a>
                </div>
                @auth
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.index') }}" class="text-sm text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC]">
                            Admin Panel
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC]">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="text-sm text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC]">
                                Login
                            </a>
                        @endif
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <div>
        <div class="blogs-bg">
            <div class="green-ball">
                <img src="{{ asset('images/home/greenball.png') }}" style="max-width: 100%;">
            </div>
            <div class="container">
                <div class="row-centered">
                    <div class="header">
                        <h1>Blogs</h1>
                        <h3>Turning sustainability intelligence into action.</h3>
                        <h3>Explore insights on carbon accounting software, ESG reporting, decarbonization, climate technology, and the path to Net Zero.</h3>
                    </div>
                </div>
            </div>
        </div>

        <img src="/images/home/greenball-side.png" style="max-width: 100%; position: absolute; right: 0; top: 80%;">

        <!-- Blog Tabs Section - Desktop -->
        <div class="blog-tabs-section d-none d-md-block">
            <div class="container p-0">
                <!-- Tab Navigation -->
                <div class="tab-navigation">
                    <button class="tab-btn active" onclick="showTab('all')">All</button>
                    <button class="tab-btn" onclick="showTab('carbon-accounting')">Carbon Accounting</button>
                    <button class="tab-btn" onclick="showTab('hospitality')">Hospitality & Tourism</button>
                    <button class="tab-btn" onclick="showTab('net-zero')">Net Zero & Strategy</button>
                    <button class="tab-btn" onclick="showTab('regulations')">Regulations & Disclosure</button>
                </div>

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- All Blogs Tab -->
                    <div id="all" class="tab-panel active">
                        <div id="blog-content" class="blog-cards-grid p-0">
                            @foreach($blogs as $post)
                            <div class="blog-card">
                                <div class="blog-card-image">
                                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                                </div>
                                <div class="blog-card-content">
                                    <div class="blog-content-wrapper">
                                        <div class="author mt-3">
                                                <div class="blog-author">{{ optional($post->user)->name ?? 'Author' }}</div>
                                                <div class="blog-date">{{ $post->created_at->format('M d, Y') }}</div>
                                        </div>
                                            <h3 class="blog-title">{{ $post->title }}</h3>
                                            <p class="blog-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($post->content)), 180) }}</p>
                                        </div>
                                        <h6 class="blog-read-more">
                                            <a href="{{ route('article.show', $post) }}" style="color: inherit; text-decoration: none;">Read More</a>
                                            <img src="{{ asset('images/home/arrow.svg') }}" alt="Arrow">
                                        </h6>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        <!-- Pagination -->
                        <div class="pagination-wrapper mt-5" id="blog-pagination">
                            {{ $blogs->fragment('blog-content')->links() }}
                        </div>
                    </div>

                    <!-- Carbon Accounting Tab -->
                    <div id="carbon-accounting" class="tab-panel">
                        <div class="blog-cards-grid">
                            @foreach($carbonAccountingBlogs as $post)
                            <div class="blog-card">
                                <div class="blog-card-image">
                                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                                </div>
                                <div class="blog-card-content">
                                    <div class="blog-content-wrapper">
                                        <div class="author mt-3">
                                                <div class="blog-author">{{ optional($post->user)->name ?? 'Author' }}</div>
                                                <div class="blog-date">{{ $post->created_at->format('M d, Y') }}</div>
                                        </div>
                                            <h3 class="blog-title">{{ $post->title }}</h3>
                                            <p class="blog-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($post->content)), 180) }}</p>
                                        </div>
                                        <h6 class="blog-read-more">
                                            <a href="{{ route('article.show', $post) }}" style="color: inherit; text-decoration: none;">Read More</a>
                                            <img src="{{ asset('images/home/arrow.svg') }}" alt="Arrow">
                                        </h6>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Hospitality & Tourism Tab -->
                    <div id="hospitality" class="tab-panel">
                        <div class="blog-cards-grid">
                            @foreach($hospitalityBlogs as $post)
                            <div class="blog-card">
                                <div class="blog-card-image">
                                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                                </div>
                                <div class="blog-card-content">
                                    <div class="blog-content-wrapper">
                                        <div class="author mt-3">
                                                <div class="blog-author">{{ optional($post->user)->name ?? 'Author' }}</div>
                                                <div class="blog-date">{{ $post->created_at->format('M d, Y') }}</div>
                                        </div>
                                            <h3 class="blog-title">{{ $post->title }}</h3>
                                            <p class="blog-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($post->content)), 180) }}</p>
                                        </div>
                                        <h6 class="blog-read-more">
                                            <a href="{{ route('article.show', $post) }}" style="color: inherit; text-decoration: none;">Read More</a>
                                            <img src="{{ asset('images/home/arrow.svg') }}" alt="Arrow">
                                        </h6>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Net Zero Tab -->
                    <div id="net-zero" class="tab-panel">
                        <div class="blog-cards-grid">
                            @foreach($netZeroBlogs as $post)
                            <div class="blog-card">
                                <div class="blog-card-image">
                                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                                </div>
                                <div class="blog-card-content">
                                    <div class="blog-content-wrapper">
                                        <div class="author mt-3">
                                                <div class="blog-author">{{ optional($post->user)->name ?? 'Author' }}</div>
                                                <div class="blog-date">{{ $post->created_at->format('M d, Y') }}</div>
                                        </div>
                                            <h3 class="blog-title">{{ $post->title }}</h3>
                                            <p class="blog-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($post->content)), 180) }}</p>
                                        </div>
                                        <h6 class="blog-read-more">
                                            <a href="{{ route('article.show', $post) }}" style="color: inherit; text-decoration: none;">Read More</a>
                                            <img src="{{ asset('images/home/arrow.svg') }}" alt="Arrow">
                                        </h6>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Regulations Tab -->
                    <div id="regulations" class="tab-panel">
                        <div class="blog-cards-grid">
                            @foreach($regulationsBlogs as $post)
                            <div class="blog-card">
                                <div class="blog-card-image">
                                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                                </div>
                                <div class="blog-card-content">
                                    <div class="blog-content-wrapper">
                                        <div class="author mt-3">
                                                <div class="blog-author">{{ optional($post->user)->name ?? 'Author' }}</div>
                                                <div class="blog-date">{{ $post->created_at->format('M d, Y') }}</div>
                                        </div>
                                            <h3 class="blog-title">{{ $post->title }}</h3>
                                            <p class="blog-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($post->content)), 180) }}</p>
                                        </div>
                                        <h6 class="blog-read-more">
                                            <a href="{{ route('article.show', $post) }}" style="color: inherit; text-decoration: none;">Read More</a>
                                            <img src="{{ asset('images/home/arrow.svg') }}" alt="Arrow">
                                        </h6>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Blog Cards - 2x2 Grid -->
        <div class="blog-tabs-section-mobile d-block d-md-none">
            <div class="container p-0">
                <!-- Tab Navigation -->
                <div class="tab-navigation">
                    <button class="tab-btn active" onclick="showTabMobile('all')">All</button>
                    <button class="tab-btn" onclick="showTabMobile('carbon-accounting')">Carbon Accounting</button>
                    <button class="tab-btn" onclick="showTabMobile('hospitality')">Hospitality &amp; Tourism</button>
                    <button class="tab-btn" onclick="showTabMobile('net-zero')">Net Zero &amp; Strategy</button>
                    <button class="tab-btn" onclick="showTabMobile('regulations')">Regulations &amp; Disclosure</button>
                </div>

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- All Blogs Tab -->
                    <div id="all-mobile" class="tab-panel active">
                        <div class="blog-cards-grid-mobile p-0">
                            @foreach($blogs as $post)
                                <div class="blog-card-mobile">
                                    <div class="blog-card-image-mobile">
                                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                                    </div>
                                    <div class="blog-card-content-mobile">
                                        <div class="author-mobile mt-3">
                                            <div class="blog-author-mobile">{{ optional($post->user)->name ?? 'Admin' }}</div>
                                            <div class="blog-date-mobile">{{ $post->created_at->format('M d, Y') }}</div>
                                        </div>
                                        <h3 class="blog-title-mobile">{{ $post->title }}</h3>
                                        <p class="blog-excerpt-mobile">{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($post->content)), 120) }}</p>
                                        <h6 class="blog-read-more-mobile">
                                            <a href="{{ route('article.show', $post) }}" style="color: inherit; text-decoration: none;">Read More</a>
                                            <img src="{{ asset('images/home/arrow.svg') }}" alt="Arrow">
                                        </h6>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Carbon Accounting Tab Mobile -->
                    <div id="carbon-accounting-mobile" class="tab-panel">
                        <div class="blog-cards-grid-mobile">
                            @foreach($carbonAccountingBlogs as $post)
                                <div class="blog-card-mobile">
                                    <div class="blog-card-image-mobile">
                                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                                    </div>
                                    <div class="blog-card-content-mobile">
                                        <div class="author-mobile mt-3">
                                            <div class="blog-author-mobile">{{ optional($post->user)->name ?? 'Author' }}</div>
                                            <div class="blog-date-mobile">{{ $post->created_at->format('M d, Y') }}</div>
                                        </div>
                                        <h3 class="blog-title-mobile">{{ $post->title }}</h3>
                                        <p class="blog-excerpt-mobile">{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($post->content)), 120) }}</p>
                                        <h6 class="blog-read-more-mobile">
                                            <a href="{{ route('article.show', $post) }}" style="color: inherit; text-decoration: none;">Read More</a>
                                            <img src="{{ asset('images/home/arrow.svg') }}" alt="Arrow">
                                        </h6>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Hospitality Tab Mobile -->
                    <div id="hospitality-mobile" class="tab-panel">
                        <div class="blog-cards-grid-mobile">
                            @foreach($hospitalityBlogs as $post)
                                <div class="blog-card-mobile">
                                    <div class="blog-card-image-mobile">
                                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                                    </div>
                                    <div class="blog-card-content-mobile">
                                        <div class="author-mobile mt-3">
                                            <div class="blog-author-mobile">{{ optional($post->user)->name ?? 'Author' }}</div>
                                            <div class="blog-date-mobile">{{ $post->created_at->format('M d, Y') }}</div>
                                        </div>
                                        <h3 class="blog-title-mobile">{{ $post->title }}</h3>
                                        <p class="blog-excerpt-mobile">{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($post->content)), 120) }}</p>
                                        <h6 class="blog-read-more-mobile">
                                            <a href="{{ route('article.show', $post) }}" style="color: inherit; text-decoration: none;">Read More</a>
                                            <img src="{{ asset('images/home/arrow.svg') }}" alt="Arrow">
                                        </h6>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Net Zero Tab Mobile -->
                    <div id="net-zero-mobile" class="tab-panel">
                        <div class="blog-cards-grid-mobile">
                            @foreach($netZeroBlogs as $post)
                                <div class="blog-card-mobile">
                                    <div class="blog-card-image-mobile">
                                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                                    </div>
                                    <div class="blog-card-content-mobile">
                                        <div class="author-mobile mt-3">
                                            <div class="blog-author-mobile">{{ optional($post->user)->name ?? 'Author' }}</div>
                                            <div class="blog-date-mobile">{{ $post->created_at->format('M d, Y') }}</div>
                                        </div>
                                        <h3 class="blog-title-mobile">{{ $post->title }}</h3>
                                        <p class="blog-excerpt-mobile">{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($post->content)), 120) }}</p>
                                        <h6 class="blog-read-more-mobile">
                                            <a href="{{ route('article.show', $post) }}" style="color: inherit; text-decoration: none;">Read More</a>
                                            <img src="{{ asset('images/home/arrow.svg') }}" alt="Arrow">
                                        </h6>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Regulations Tab Mobile -->
                    <div id="regulations-mobile" class="tab-panel">
                        <div class="blog-cards-grid-mobile">
                            @foreach($regulationsBlogs as $post)
                                <div class="blog-card-mobile">
                                    <div class="blog-card-image-mobile">
                                        <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
                                    </div>
                                    <div class="blog-card-content-mobile">
                                        <div class="author-mobile mt-3">
                                            <div class="blog-author-mobile">{{ optional($post->user)->name ?? 'Author' }}</div>
                                            <div class="blog-date-mobile">{{ $post->created_at->format('M d, Y') }}</div>
                                        </div>
                                        <h3 class="blog-title-mobile">{{ $post->title }}</h3>
                                        <p class="blog-excerpt-mobile">{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($post->content)), 120) }}</p>
                                        <h6 class="blog-read-more-mobile">
                                            <a href="{{ route('article.show', $post) }}" style="color: inherit; text-decoration: none;">Read More</a>
                                            <img src="{{ asset('images/home/arrow.svg') }}" alt="Arrow">
                                        </h6>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom - Desktop Version -->
        <div class="container bottom d-none d-md-block">
            <h2>Join Our Waitlist</h2>
            <div class="my-5">
                <a href="{{ url('/waitlist') }}" class="start-for-free-btn">Start for Free</a>
                <a href="{{ url('/waitlist') }}" class="request-demo-btn">Request a Demo</a>
            </div>
        </div>

        <!-- Bottom - Mobile Version -->
        <div class="container bottom-mobile d-flex d-md-none mb-5">
            <div class="bottom-card-mobile">
                <h2>Join Our Waitlist</h2>
                <div class="bottom-buttons mt-4" style="display: flex; flex-direction: column; align-items: center;">
                    <a href="{{ url('/waitlist') }}" class="start-for-free-btn">Start for Free</a>
                    <a href="{{ url('/waitlist') }}" class="request-demo-btn mt-3">Request a Demo</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabId) {
            // Hide all tab panels
            const panels = document.querySelectorAll('.tab-panel');
            panels.forEach(panel => {
                panel.classList.remove('active');
            });

            // Remove active class from all tab buttons
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(button => {
                button.classList.remove('active');
            });

            // Show the selected tab panel
            const selectedPanel = document.getElementById(tabId);
            if (selectedPanel) {
                selectedPanel.classList.add('active');
            }

            // Add active class to the clicked button
            const clickedButton = event.target;
            clickedButton.classList.add('active');
        }

        function showTabMobile(tabId) {
            // Hide all tab panels
            const panels = document.querySelectorAll('.tab-panel');
            panels.forEach(panel => {
                panel.classList.remove('active');
            });

            // Remove active class from all tab buttons
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(button => {
                button.classList.remove('active');
            });

            // Show the selected tab panel
            const selectedPanel = document.getElementById(tabId + '-mobile');
            if (selectedPanel) {
                selectedPanel.classList.add('active');
            }

            // Add active class to the clicked button
            const clickedButton = event.target;
            clickedButton.classList.add('active');
        }
    </script>

    <!-- Pagination Scroll Fix -->
    <script>
        (function() {
            // Check if we need to scroll after pagination
            if (localStorage.getItem('scrollAfterPagination') === 'true') {
                localStorage.removeItem('scrollAfterPagination');

                // Try multiple times until element is found
                let attempts = 0;
                const maxAttempts = 10;

                function scrollToBlog() {
                    attempts++;
                    const blogSection = document.getElementById('blog-content');

                    if (blogSection) {
                        const offsetTop = blogSection.offsetTop;
                        window.scrollTo({
                            top: offsetTop - 200,
                            behavior: 'instant'
                        });
                    } else if (attempts < maxAttempts) {
                        requestAnimationFrame(scrollToBlog);
                    }
                }

                scrollToBlog();
            }
        })();
    </script>
</body>
</html>

