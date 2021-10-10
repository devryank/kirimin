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
    @stack('css')
    @livewireStyles
</head>

<body class="antialiased">
    @if (Route::has('login'))
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-3 px-6 py-4">
            <h1 class="text-2xl">KIRIMIN</h1>
        </div>
        <div class="col-span-9 px-6 py-4 text-right">
            @auth
            <a href="{{ url('/dashboard') }}" class="mx-2 text-sm text-gray-700 underline">Profile</a>
            <a href="{{ url('/cart') }}" class="mx-2 text-sm text-gray-700 underline">Cart</a>
            <a href="{{ route('logout') }}" class="mx-2 text-sm text-gray-700 underline" onclick="event.preventDefault();
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

    <footer class="px-14 mt-10">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-start-2 col-span-3">
                <h5>Layanan</h5>
                <ul>
                    <li>
                        <a href="#" class="text-sm text-blue-500 hover:underline">Bantuan</a>
                    </li>
                    <li>
                        <a href="#" class="text-sm text-blue-500 hover:underline">FAQ</a>
                    </li>
                    <li>
                        <a href="#" class="text-sm text-blue-500 hover:underline">Metode Pembayaran</a>
                    </li>
                    <li>
                        <a href="#" class="text-sm text-blue-500 hover:underline">Lacak Pesanan</a>
                    </li>
                    <li>
                        <a href="#" class="text-sm text-blue-500 hover:underline">Hubungi Kami</a>
                    </li>
                </ul>
            </div>

            <div class="col-span-3">
                <h5>Halaman</h5>
                <ul>
                    <li>
                        <a href="#" class="text-sm text-blue-500 hover:underline">Syarat &amp; Ketentuan</a>
                    </li>
                    <li>
                        <a href="#" class="text-sm text-blue-500 hover:underline">Kebijakan Privasi</a>
                    </li>
                </ul>
            </div>

            {{-- <div class="col-span-3">
                <h5>Pembayaran</h5>
                <img class="logo" src="assets/img/bca.png" width="50px">
                <img class="logo" src="assets/img/bri.png" width="75px">
                <img class="logo" src="assets/img/gopay.png" width="65px">
                <img class="logo" src="assets/img/dana.png" width="60px">
                <img class="logo" src="assets/img/ovo.png" width="50px">
                <img class="logo" src="assets/img/alfamart.png" width="50px">
                <img class="logo" src="assets/img/indomaret.png" width="60px">

                <h5 class="mt-4" id="coba-coba">Jasa Pengiriman</h5>

                <img class="logo" src="assets/img/jne.png" width="60px">
                <img class="logo" src="assets/img/gosend.png" width="70px">
                <img class="logo" src="assets/img/grab-express.png" width="75px">
                <img class="logo" src="assets/img/ninja-express.png" width="60px">
            </div> --}}

            <div class="col-span-4">
                <p>Kirimin adalah wadah para pedagang untuk menjualkan dagangannya kepada lebih banyak orang secara
                    online.</p>
            </div>
        </div>
    </footer>
    @stack('js')
    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    @livewireScripts
</body>

</html>