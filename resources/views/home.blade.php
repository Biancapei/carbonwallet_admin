<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'CarbonAI') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @php
        $assets = \App\Helpers\AssetHelper::getViteAssets();
    @endphp
    @if(app()->environment('production') && $assets['css'] && $assets['js'])
        <link rel="stylesheet" href="{{ $assets['css'] }}">
        <script src="{{ $assets['js'] }}"></script>
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link rel="stylesheet" href="{{ secure_asset('css/style.css') }}">
</head>
<body style="background-color: #000;">
    <!-- Navigation -->
    <nav>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                        CarbonAI  Admin
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

    <!-- Blog Carousel Section -->
    @if($blogs->count() > 0)
        <section class="py-16" style="background-color: #000;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">Latest Blog Posts</h2>
                    <p class="text-lg text-[#706f6c] dark:text-[#A1A09A]">Stay updated with our latest insights</p>
                </div>

                <!-- Carousel Container with External Navigation -->
                <div class="relative">
                    <!-- Navigation Arrows - Outside the carousel container -->
                    <button onclick="previousSlide()" class="carousel-nav-btn left">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button onclick="nextSlide()" class="carousel-nav-btn right">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                    <!-- Carousel Content -->
                    <div class="carousel-container">
                        <div class="carousel-track" id="carouselTrack">
                            @foreach($blogs as $index => $blog)
                                <div class="carousel-slide px-4">
                                    <div class="carousel-card bg-white dark:bg-[#1a1a1a] rounded-lg shadow-lg overflow-hidden mx-auto">
                                        <div class="w-full">
                                            <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" class="w-full h-64 object-cover">
                                        </div>
                                        <div class="p-8 w-full">
                                            <h3 class="text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">{{ $blog->title }}</h3>
                                            <p class="text-[#706f6c] dark:text-[#A1A09A] leading-relaxed mb-2">
                                                {{ Str::limit(strip_tags($blog->content), 200) }}
                                            </p>
                                            <span class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                                                {{ $blog->created_at->format('M d, Y') }}
                                            </span>
                                            <div class="flex items-center justify-between mt-2">
                                                <a href="{{ route('article.show', $blog) }}" class="read-more-btn">
                                                    Read More →
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Dots -->
                    <div class="carousel-dots">
                        @php
                            $slidesPerView = 3; // Default for desktop
                            $maxSlides = max(1, $blogs->count() - $slidesPerView + 1);
                        @endphp
                        @for($i = 0; $i < $maxSlides; $i++)
                            <div class="carousel-dot {{ $i === 0 ? 'active' : '' }}" onclick="goToSlide({{ $i }})"></div>
                        @endfor
                    </div>
                </div>
            </div>
        </section>
    @endif

    <script>
        let currentSlide = 0;
        const totalSlides = {{ $blogs->count() }};
        const slidesPerView = window.innerWidth <= 480 ? 1 : window.innerWidth <= 768 ? 2 : 3;
        const maxSlides = Math.max(1, totalSlides - slidesPerView + 1);

        function updateCarousel() {
            const track = document.getElementById('carouselTrack');
            const dots = document.querySelectorAll('.carousel-dot');

            if (track) {
                const slideWidth = 100 / slidesPerView;
                track.style.transform = `translateX(-${currentSlide * slideWidth}%)`;
            }

            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
            });
        }

        function nextSlide() {
            if (currentSlide < maxSlides - 1) {
                currentSlide++;
            } else {
                currentSlide = 0;
            }
            updateCarousel();
        }

        function previousSlide() {
            if (currentSlide > 0) {
                currentSlide--;
            } else {
                currentSlide = maxSlides - 1;
            }
            updateCarousel();
        }

        function goToSlide(index) {
            currentSlide = index;
            updateCarousel();
        }

        // Handle window resize
        window.addEventListener('resize', function() {
            const newSlidesPerView = window.innerWidth <= 480 ? 1 : window.innerWidth <= 768 ? 2 : 3;
            if (newSlidesPerView !== slidesPerView) {
                location.reload(); // Reload to recalculate
            }
        });

        // Auto-play carousel
        if (totalSlides > slidesPerView) {
            setInterval(nextSlide, 5000);
        }
    </script>
</body>
</html>
