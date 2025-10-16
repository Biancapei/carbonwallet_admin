<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - {{ config('app.name', 'CarbonAI') }}</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo" style="justify-content: center; display: flex;">
            <img src="{{ secure_asset('images/logo.svg') }}" class="logo-img">
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('home') }}" class="nav-item">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            <a href="{{ route('admin.index') }}" class="nav-item {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                <i class="fas fa-blog"></i>
                <span>Blogs</span>
            </a>
        </nav>

        <!-- Logout button at bottom -->
        <div class="sidebar-bottom">
            <form method="POST" action="{{ route('logout') }}" class="nav-item" style="cursor: pointer; border-top: 1px solid rgba(255,255,255,0.1);" onclick="this.submit()">
                @csrf
                <i class="fas fa-power-off"></i>
                <span>Log Out</span>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h1>CarbonAI</h1>
            </div>
            <div class="header-right">
                {{-- <span style="color: #374151; font-weight: 500;">Admin</span> --}}
                <div>
                    <i class="fas fa-user" style="color: white; font-size: 14px;"></i>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            @if(session('success'))
                <div style="background: #d1fae5; border: 1px solid #10b981; color: #065f46; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background: #fee2e2; border: 1px solid #ef4444; color: #991b1b; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');

            sidebar.classList.toggle('sidebar-collapsed');
            mainContent.classList.toggle('main-content-collapsed');

            if (sidebar.classList.contains('sidebar-collapsed')) {
                toggleBtn.className = 'fas fa-chevron-right';
            } else {
                toggleBtn.className = 'fas fa-chevron-left';
            }
        }
    </script>
</body>
</html>
