<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    @vite('resources/css/app.css')
</head>
<body class="h-screen bg-gray-100 dark:bg-gray-900 flex flex-col">

    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="container mx-auto flex justify-between items-center py-6 px-4 lg:px-8">
            <div class="flex items-center">
                <svg class="h-12 w-auto text-[#FF2D20]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 62 65" fill="none">
                    <!-- SVG content -->
                </svg>
                <span class="ml-3 text-xl font-bold text-gray-800 dark:text-white">LARAVEL AI</span>
            </div>
            @if (Route::has('login'))
                <nav class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-800 dark:text-white hover:underline">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-800 dark:text-white hover:underline">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-gray-800 dark:text-white hover:underline">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <main class="flex-grow flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-4xl font-extrabold text-gray-800 dark:text-white sm:text-5xl">
                Welcome to Laravel AI
            </h1>
            <p class="mt-2 text-lg text-gray-600 dark:text-gray-300">
                Chat with OpenAI and your friends
            </p>
            <div class="mt-4 space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-6 py-3 bg-[#FF2D20] text-white rounded-md hover:bg-[#e0261c]">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-3 bg-[#FF2D20] text-white rounded-md hover:bg-[#e0261c]">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-6 py-3 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                            Register
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </main>


    <footer class="bg-white dark:bg-gray-800 py-6">
        <div class="container mx-auto text-center text-gray-600 dark:text-gray-300">
            &copy; {{ date('Y') }} My App. All rights reserved.
        </div>
    </footer>
</body>
</html>
