<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'CarbonAI') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

    <!-- Hero (from carbonwallet homepage) -->
    <div>
        <div class="homepage-bg">
            <div class="green-ball">
                <img src="{{ asset('images/home/greenball.png') }}" style="max-width: 100%;">
            </div>
            <div class="container">
                <div class="row-centered">
                    <div class="header">
                        <h1>AI for Net Zero</h1>
                        <h3>The audit-ready ESG and carbon accounting platform that validates Scope 1–3 data with AI precision.</h3>
                    </div>
                    <div class="header-btn">
                        <a href="{{ url('/waitlist') }}" class="start-for-free-btn">Start for Free</a> &nbsp;&nbsp;
                        <a href="{{ url('/waitlist') }}" class="request-demo-btn">Request a Demo</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Display Images - Desktop -->
        <div class="container-fluid display-section p-0 d-md-block d-none" style="background-image: url('{{ asset('images/home/faded-green.png') }}'); background-size: contain; background-position: center; background-repeat: no-repeat;">
            <div class="display-wrapper">
                <img src="{{ asset('images/home/display-top.png') }}" alt="Display Top" class="display-image">
                <img src="{{ asset('images/home/display-btm.png') }}" alt="Display Bottom" class="display-image">
            </div>
        </div>

        <!-- Display Images - Mobile -->
        <div class="container">
            <div class="display-wrapper d-block d-md-none px-3" style="margin-top: -15rem;">
                <img src="{{ asset('images/home/display-top.png') }}" alt="Display Top" class="display-image">
                <img src="{{ asset('images/home/display-btm.png') }}" alt="Display Bottom" class="display-image mt-4">
            </div>
        </div>

        <!-- Value Proposition -->
        <div class="value-proposition">
            <div class="container">
                <h3>Value Proposition</h3>
                <div class="row align-items-center value-proposition-content">
                    <div class="col-12 col-md-6 text-center">
                        <img src="{{ asset('images/home/pic6.png') }}" class="img-fluid rounded shadow" style="z-index: 3; position: relative;">
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="value-boxes">
                            <div class="value-box" onclick="toggleValueBox(this)">
                                <div class="value-header">
                                    <h4 class="value-title">Validate</h4>
                                    <button class="dropdown-arrow">↓</button>
                                </div>
                                <div class="value-divider"></div>
                                <p class="value-description">AI-powered and audit-ready ESG data validation for Scope 1-3 emissions.</p>
                            </div>

                            <div class="value-box" onclick="toggleValueBox(this)">
                                <div class="value-header">
                                    <h4 class="value-title">Enrich</h4>
                                    <button class="dropdown-arrow">↓</button>
                                </div>
                                <div class="value-divider"></div>
                                <p class="value-description">Enhance accuracy with localized emission factors and confidence scoring.</p>
                            </div>

                            <div class="value-box" onclick="toggleValueBox(this)">
                                <div class="value-header">
                                    <h4 class="value-title">Connect</h4>
                                    <button class="dropdown-arrow">↓</button>
                                </div>
                                <div class="value-divider"></div>
                                <p class="value-description">Integrate seamlessly with carbon accounting software, registries, and financial systems through API.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <img src="/images/home/greenball-side.png" style="max-width: 100%; position: absolute; left: 0; top: 250%; transform: scaleX(-1);" class="greenball-side">
        </div>

        <!-- Case Tiles - Desktop -->
        <div class="cards d-none d-md-block">
            <div class="container">
                <div class="row g-4 mt-4">
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card h-100" style="background-image: url('{{ asset('images/home/pic1.png') }}'); background-size: cover; background-position: center;">
                            <div class="card-body">
                                <h4>Hospitality & <br>Tourism</h4>
                                <div class="content-row">
                                    <p>Guest-level sustainability data that converts into verified carbon savings.</p>
                                    <a href=""><img src="/images/home/arrow.svg"></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card h-100" style="background-image: url('{{ asset('images/home/pic2.png') }}'); background-size: cover; background-position: center;">
                            <div class="card-body">
                                <h4 style="color: #1AB3C5">Finance & <br>Investments</h4>
                                <div class="content-row">
                                    <p>Verified ESG data for green loans, bonds, and carbon-linked financing.</p>
                                    <a href=""><img src="/images/home/arrow.svg"></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card h-100" style="background-image: url('{{ asset('images/home/pic3.png') }}'); background-size: cover; background-position: center;">
                            <div class="card-body">
                                <h4>Supply Chain & Manufacturing</h4>
                                <div class="content-row">
                                    <p>AI validation for supplier Scope 1-3 disclosures and benchmarking.</p>
                                    <a href=""><img src="/images/home/arrow.svg"></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card h-100" style="background-image: url('{{ asset('images/home/pic4.png') }}'); background-size: cover; background-position: center;">
                            <div class="card-body">
                                <h4 style="color: #1AB3C5">Corporate &<br> Integration</h4>
                                <div class="content-row">
                                    <p>Plug Carbon AI into your ESG, POS, or ERP systems seamlessly.</p>
                                    <a href=""><img src="/images/home/arrow.svg"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <img src="/images/home/greenball-side.png" class="greenball-side-right">
        </div>

        <!-- Cards - Mobile Version -->
        <div class="cards-mobile d-block d-md-none px-3">
            <div class="container">
                <div class="row">
                    <div class="col-6 my-4">
                        <div class="card-mobile h-100" style="background-image: url('{{ asset('images/home/pic1.png') }}'); background-size: cover; background-position: center;">
                            <div class="card-body-mobile">
                                <h4>Hospitality &amp; <br>Tourism</h4>
                                <div class="content-row-mobile">
                                    <p>Guest-level sustainability data that converts into verified carbon savings.</p>
                                    <a href=""><img src="{{ asset('images/home/arrow.svg') }}"></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 my-4">
                        <div class="card-mobile h-100" style="background-image: url('{{ asset('images/home/pic2.png') }}'); background-size: cover; background-position: center;">
                            <div class="card-body-mobile">
                                <h4 style="color: #1AB3C5">Finance &amp; <br>Investments</h4>
                                <div class="content-row-mobile">
                                    <p>Verified ESG data for green loans, bonds, and carbon-linked financing.</p>
                                    <a href=""><img src="{{ asset('images/home/arrow.svg') }}"></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="card-mobile h-100" style="background-image: url('{{ asset('images/home/pic3.png') }}'); background-size: cover; background-position: center;">
                            <div class="card-body-mobile">
                                <h4>Supply Chain &amp; Manufacturing</h4>
                                <div class="content-row-mobile">
                                    <p>AI validation for supplier Scope 1-3 disclosures and benchmarking.</p>
                                    <a href=""><img src="{{ asset('images/home/arrow.svg') }}"></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="card-mobile h-100" style="background-image: url('{{ asset('images/home/pic4.png') }}'); background-size: cover; background-position: center;">
                            <div class="card-body-mobile">
                                <h4 style="color: #1AB3C5">Corporate &amp; Integration</h4>
                                <div class="content-row-mobile">
                                    <p>Plug Carbon AI into your ESG, POS, or ERP systems seamlessly.</p>
                                    <a href=""><img src="{{ asset('images/home/arrow.svg') }}"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Differentiation -->
        <div class="differentiation">
            <div class="container differentiation-content">
                <div class="row">
                    <div class="col-12 col-md-6" style="display: flex; flex-direction: column; justify-content: center;">
                        <h2 style="-webkit-text-fill-color: #fff;">Others measure.</h2>
                        <h2>We validate.</h2>
                        <div class="my-3">
                            <h3>Carbon AI isn’t just a reporting platform. It is an AI driven verification layer linking ESG and carbon accounting data to financial markets.</h3>
                        </div>
                        <div class="my-3"><a href="{{ url('/waitlist') }}" class="request-demo-btn m-0">Request a Demo</a></div>
                    </div>
                    <div class="col-12 col-md-6">
                        <img src="{{ asset('images/home/pic5.png') }}" class="differentiation-img img-fluid rounded shadow" style="float: right;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Logos -->
        <div class="logos" style="background: #fff; position: relative;">
            <div class="logos-wrapper"">
                <div class="logos-slider" id="logosSlider">
                    <img src="{{ asset('images/home/logo1.svg') }}" alt="Logo 1">
                    <img src="{{ asset('images/home/logo2.svg') }}" alt="Logo 2">
                    <img src="{{ asset('images/home/logo3.svg') }}" alt="Logo 3">
                    <img src="{{ asset('images/home/logo4.svg') }}" alt="Logo 4">
                    <img src="{{ asset('images/home/logo5.svg') }}" alt="Logo 5">
                    <img src="{{ asset('images/home/logo6.svg') }}" alt="Logo 6">
                    <img src="{{ asset('images/home/logo7.svg') }}" alt="Logo 7">
                    <img src="{{ asset('images/home/logo8.svg') }}" alt="Logo 8">
                </div>
            </div>
        </div>
        <img src="/images/home/greenball-side.png" class="greenball-side-left-top">
    </div>

    <!-- Blog Carousel Section -->
    @if($blogs->count() > 0)
        <section style="background-color: #000;">
            <div class="insights max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-6">
                    <h3>Stay Ahead of the Curve</h3>
                    <h5>Discover verified carbon data and decarbonization insights aligned with SBTi and global disclosure standards.</h5>
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
                                <div class="carousel-slide">
                                    <div class="blog-card">
                                        <div class="blog-card-image">
                                            <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}">
                                        </div>
                                        <div class="blog-card-content">
                                            <div class="blog-content-wrapper">
                                                <div class="author mt-3">
                                                    <div class="blog-author">{{ optional($blog->user)->name ?? 'Author' }}</div>
                                                    <div class="blog-date">{{ $blog->created_at->format('M d, Y') }}</div>
                                                </div>
                                                <h6 class="blog-title">{{ $blog->title }}</h6>
                                                <p class="blog-excerpt">{{ Str::limit(strip_tags(html_entity_decode($blog->content)), 180) }}</p>
                                            </div>
                                            <h6 class="blog-read-more">
                                                <a href="{{ route('article.show', $blog) }}" class="blog-read-more-link">Read More</a>
                                                <img src="{{ asset('images/home/arrow.svg') }}" alt="Arrow">
                                            </h6>
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

    <!-- Insights - Mobile Version (added from carbonwallet homepage) -->
    <div class="insights-mobile d-block d-md-none">
        <div class="container">
            <h3>Stay Ahead of the Curve</h3>
            <h5 class="my-3">Discover verified carbon data and decarbonization insights aligned with SBTi and global disclosure standards.</h5>
            <div class="row mt-5">
                <div class="col-6">
                    <div class="insights-card-mobile">
                        <div class="insights-card-body-mobile">
                            <h4>Finance Emissions Guide</h4>
                            <div class="insights-content-row-mobile">
                                <a href="#" class="insights-link-mobile">Explore Insights</a>
                                <a href="#" class="insights-arrow-mobile">
                                    <img src="{{ asset('images/home/arrow.svg') }}" alt="Arrow">
                                </a>
                            </div>
                            <img src="{{ asset('images/blog1.jpg') }}" alt="Finance Emission" class="insights-image-mobile">
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="insights-card-mobile">
                        <div class="insights-card-body-mobile">
                            <h4 class="insights-title-cyan-mobile">Supplier Data Exchange</h4>
                            <div class="insights-content-row-mobile">
                                <a href="#" class="insights-link-mobile">Explore Insights</a>
                                <a href="#" class="insights-arrow-mobile">
                                    <img src="{{ asset('images/home/arrow.svg') }}" alt="Arrow">
                                </a>
                            </div>
                            <img src="{{ asset('images/blog2.jpg') }}" alt="Supplier Data Exchange" class="insights-image-mobile">
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="insights-card-mobile">
                        <div class="insights-card-body-mobile">
                            <h4>Scope 3 Decarbonization Insights (Asia & GBA)</h4>
                            <div class="insights-content-row-mobile">
                                <a href="#" class="insights-link-mobile">Explore Insights</a>
                                <a href="#" class="insights-arrow-mobile">
                                    <img src="{{ asset('images/home/arrow.svg') }}" alt="Arrow">
                                </a>
                            </div>
                            <img src="{{ asset('images/blog3.jpg') }}" alt="Corporate Integration" class="insights-image-mobile">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Bottom - Desktop Version -->
    <div class="container bottom d-none d-md-block">
        <h2>Carbon data you can trust</h2>
        <div class="my-5">
            <a href="{{ url('/waitlist') }}" class="start-for-free-btn">Start for Free</a>
            <a href="{{ url('/waitlist') }}" class="request-demo-btn">Request a Demo</a>
        </div>
    </div>

    <script>
        // Value Proposition toggle
        function toggleValueBox(element) {
            document.querySelectorAll('.value-box').forEach(function(box) {
                box.classList.remove('active');
            });
            element.classList.add('active');
        }

        // Logos slider gentle marquee
        document.addEventListener('DOMContentLoaded', function () {
            const firstValueBox = document.querySelector('.value-box');
            if (firstValueBox) {
                firstValueBox.classList.add('active');
            }

            const slider = document.getElementById('logosSlider');
            if (!slider) return;
            let speed = 1;
            let position = 0;
            function animate() {
                position -= speed;
                slider.style.transform = `translateX(${position}px)`;
                const firstLogo = slider.firstElementChild;
                if (!firstLogo) return;
                const firstLogoWidth = firstLogo.offsetWidth + 80;
                if (Math.abs(position) >= firstLogoWidth) {
                    slider.appendChild(firstLogo);
                    position += firstLogoWidth;
                }
                requestAnimationFrame(animate);
            }
            animate();
        });
    </script>
</body>
</html>
