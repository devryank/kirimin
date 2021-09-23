<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind Admin Template</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <!-- Tailwind -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');

        .font-family-karla {
            font-family: karla;
        }

        .bg-sidebar {
            background: #3d68ff;
        }

        .cta-btn {
            color: #3d68ff;
        }

        .upgrade-btn {
            background: #1947ee;
        }

        .upgrade-btn:hover {
            background: #0038fd;
        }

        .active-nav-link {
            background: #1947ee;
        }

        .nav-item:hover {
            background: #1947ee;
        }

        .account-link:hover {
            background: #3d68ff;
        }
    </style>
    @livewireStyles
    @stack('css')
</head>

<body class="bg-gray-100 font-family-karla flex dark:bg-gray-900">

    <aside class="relative bg-sidebar dark:bg-gray-700 h-screen w-64 hidden sm:block shadow-xl">
        <div class="p-6">
            <a href="index.html" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
            <button
                class="w-full bg-white dark:bg-blue-600 dark:text-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 dark:hover:bg-blue-800 flex items-center justify-center">
                <i class="fas fa-plus mr-3"></i> New Report
            </button>
        </div>
        <nav class="text-white text-base font-semibold pt-3">
            <a href="{{route('dashboard')}}"
                class="flex items-center {{Request::segment(2) == '' ? 'active-nav-link' : ''}} text-white py-4 pl-6 nav-item">
                <i class="fas fa-tachometer-alt mr-3"></i>
                Dashboard
            </a>

            @if (Auth::user()->hasPermissionTo('read shops'))
            <a href="{{route('dashboard.shop.index')}}"
                class="flex items-center {{Request::segment(2) == 'shops' ? 'active-nav-link' : ''}} text-white py-4 pl-6 nav-item">
                <i class="fas fa-store mr-3"></i>
                Warung
            </a>
            @endif

            @if (Auth::user()->hasPermissionTo('read users'))
            <a href="{{route('dashboard.user.index')}}"
                class="flex items-center {{Request::segment(2) == 'users' ? 'active-nav-link' : ''}} text-white py-4 pl-6 nav-item">
                <i class="fas fa-users mr-3"></i>
                Users
            </a>
            @endif

            @if (Auth::user()->hasPermissionTo('read roles'))
            <a href="{{route('dashboard.role.index')}}"
                class="flex items-center {{Request::segment(2) == 'roles' ? 'active-nav-link' : ''}} text-white py-4 pl-6 nav-item">
                <i class="fas fa-layer-group mr-3"></i>
                Roles
            </a>
            @endif
        </nav>
    </aside>

    <div class="relative w-full flex flex-col h-screen overflow-y-hidden">
        <!-- Desktop Header -->
        <header class="w-full items-center bg-white dark:bg-gray-800 py-2 px-6 hidden sm:flex">
            <div class="w-1/2"></div>
            <div x-data="{ isOpen: false }" class="relative w-1/2 flex justify-end">
                <div id="mode" class="pt-3 mr-3">
                    <i id="modeIcon" class="fas fa-toggle-off fa-2x text-blue-600 dark:text-white cursor-pointer"></i>
                </div>
                <button @click="isOpen = !isOpen"
                    class="realtive z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none">
                    <img src="https://source.unsplash.com/uJ8LNVCBjFQ/400x400">
                </button>
                <button x-show="isOpen" @click="isOpen = false"
                    class="h-full w-full fixed inset-0 cursor-default"></button>
                <div x-show="isOpen" class="absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-16 z-50">
                    <a href="{{ route('logout') }}" class="block px-4 py-2 account-link hover:text-white" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                        Sign Out
                    </a>
                    <form method="POST" id="logout-form" action="{{ route('logout') }}">
                        @csrf
                    </form>
                </div>
            </div>
        </header>

        <!-- Mobile Header & Nav -->
        <header x-data="{ isOpen: false }" class="w-full bg-sidebar py-5 px-6 sm:hidden">
            <div class="flex items-center justify-between">
                <a href="index.html" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
                <button @click="isOpen = !isOpen" class="text-white text-3xl focus:outline-none">
                    <i x-show="!isOpen" class="fas fa-bars"></i>
                    <i x-show="isOpen" class="fas fa-times"></i>
                </button>
            </div>

            <!-- Dropdown Nav -->
            <nav :class="isOpen ? 'flex': 'hidden'" class="flex flex-col pt-4">
                <a href="{{route('dashboard')}}"
                    class="flex items-center {{Request::segment(2) == '' ? 'active-nav-link' : ''}} text-white py-4 pl-6 nav-item">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                @if (Auth::user()->hasPermissionTo('read users'))
                <a href="{{route('dashboard.user.index')}}"
                    class="flex items-center {{Request::segment(2) == 'users' ? 'active-nav-link' : ''}} text-white py-4 pl-6 nav-item">
                    <i class="fas fa-users mr-3"></i>
                    Users
                </a>
                @endif
                @if (Auth::user()->hasPermissionTo('read roles'))
                <a href="{{route('dashboard.role.index')}}"
                    class="flex items-center {{Request::segment(2) == 'roles' ? 'active-nav-link' : ''}} text-white py-4 pl-6 nav-item">
                    <i class="fas fa-layer-group mr-3"></i>
                    Roles
                </a>
                @endif
                <a href="{{ route('logout') }}" class="flex items-center text-white py-4 pl-6 nav-item" onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    Sign Out
                </a>
                <form method="POST" id="logout-form" action="{{ route('logout') }}">
                    @csrf
                </form>
            </nav>
            <!-- <button class="w-full bg-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                <i class="fas fa-plus mr-3"></i> New Report
            </button> -->
        </header>

        <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                {{$slot}}
            </main>

            <footer class="w-full bg-white dark:bg-gray-800 dark:text-white text-right p-4">
                Built by <a target="_blank" href="https://davidgrzyb.com" class="underline">David Grzyb</a>.
            </footer>
        </div>

    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"
        integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <script src="{{asset('js/darkmode.js')}}"></script>

    <script>
        /*Toggle dropdown list*/
        /*https://gist.github.com/slavapas/593e8e50cf4cc16ac972afcbad4f70c8*/

        var userMenuDiv = document.getElementById("userMenu");
        var userMenu = document.getElementById("userButton");

        document.onclick = check;

        function check(e) {
            var target = (e && e.target) || (event && event.srcElement);

            //User Menu
            if (!checkParent(target, userMenuDiv)) {
                // click NOT on the menu
                if (checkParent(target, userMenu)) {
                    // click on the link
                    if (userMenuDiv.classList.contains("invisible")) {
                        userMenuDiv.classList.remove("invisible");
                    } else {
                        userMenuDiv.classList.add("invisible");
                    }
                } else {
                    // click both outside link and outside menu, hide menu
                    userMenuDiv.classList.add("invisible");
                }
            }

        }

        function checkParent(t, elm) {
            while (t.parentNode) {
                if (t == elm) {
                    return true;
                }
                t = t.parentNode;
            }
            return false;
        }
    </script>
    @stack('js')
    @livewireScripts
</body>

</html>