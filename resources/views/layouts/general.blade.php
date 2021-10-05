<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->

    <!-- Tailwind -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <style>
        html {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            line-height: 1.5
        }

        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
    @livewireStyles
</head>

<body class="antialiased">
    @if (Route::has('login'))
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-3 px-6 py-4">
            <h1 class="text-2xl">KIRIMIN</h1>
        </div>
        <div class="col-start-6 col-span-3 px-6 py-4">
            @auth
            <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Profile</a>
<a href="{{ url('/cart') }}" class="text-sm text-gray-700 underline">Cart</a>
            <a href="{{ route('logout') }}" class="text-sm text-gray-700 underline" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                Sign Out
            </a>
            <form method="POST" id="logout-form" action="{{ route('logout') }}">
                @csrf
            </form>
            @else
            <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
            @endif
            @endauth
        </div>
    </div>
    @endif
    @yield('content')

    @stack('js')
    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    @livewireScripts
</body>

</html>
