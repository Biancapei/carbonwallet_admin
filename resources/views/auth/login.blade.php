<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'CarbonAI') }}</title>
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
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white dark:bg-[#161615] shadow-lg rounded-lg p-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Admin Login</h1>
                <p class="text-[#706f6c] dark:text-[#A1A09A] mt-2">Sign in to access the admin panel</p>
            </div>

            @if($errors->any())
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                        Email Address
                    </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" class="w-full px-3 py-2 border border-gray-300 dark:border-[#3E3E3A] rounded-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-[#16d3ca] dark:focus:ring-[#16d3ca] focus:border-transparent bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC]" placeholder="Enter your email"required autofocus>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                        Password
                    </label>
                    <input type="password"
                           id="password"
                           name="password"
                           autocomplete="current-password"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-[#3E3E3A] rounded-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-[#16d3ca] dark:focus:ring-[#16d3ca] focus:border-transparent bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC]"
                           placeholder="Enter your password"
                           required>
                </div>

                <button type="submit"
                        class="w-full bg-[#1b1b18] hover:bg-black text-white py-2 px-4 rounded-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-[#1b1b18] focus:ring-offset-2">
                    Sign In
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-sm text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC]">
                    ← Back to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>
