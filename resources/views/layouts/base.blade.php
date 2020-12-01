<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-gray-200">

<head>
    <title>{{ isset($title) ? $title . ' | ' : null }}{{ config('app.name') }}</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">

    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/vendor/trov/images/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/vendor/trov/images/favicon.png') }}">

    <!-- Styles -->
    <style>
        [x-cloak],
        [v-cloak] {
            display: none;
        }

        .fa-fw {
            width: 1.25em;
        }
    </style>
    @livewireStyles()
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('vendor/trov/css/trov.css') }}">

    <!-- Scripts -->
    <script type="module" src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine-ie11.min.js" defer></script>
</head>

<body class="flex flex-col min-h-screen font-sans text-gray-900 lg:flex-row">
    <a href="#site-main" class="sr-only">Skip to main content</a>

    <nav x-data="{menuOpen: false}" class="relative w-full antialiased bg-gray-900 lg:w-64">

        <div class="flex items-center justify-between w-full h-16 px-6 py-3 text-xl font-bold text-white bg-gray-900 bg-no-repeat border-b border-gray-800" style="background: url({{ asset('vendor/trov/images/cms-geometric.png') }});">

            <div class="w-full">
                <a href="{{ config('trov.home') }}" class="flex items-center space-x-3 text-white hover:text-gray-100 focus:text-gray-100">
                    <img src="{{ config('brand.images.icon.url') ?: asset('/vendor/trov/images/icon.svg') }}" class="flex-shrink-0 w-8 h-8 overflow-hidden border border-gray-800 rounded" alt="{{ config()->has('brand.images.icon.alt') ?: 'trov icon'}}" />
                    <span class="flex-1 w-0 truncate">{{ config('app.name') }}</span>
                </a>
            </div>

            <div class="flex items-center flex-shrink-0 ml-3 space-x-3">
                @if (app('menu.newitems')->count() > 0)
                <div x-data="{open:false}" class="relative h-6">
                    <button x-on:click="open = !open" x-on:keydown.escape.window="open = false" x-on:click.away="open = false">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="absolute right-0 left-auto z-10 w-56 mt-2 bg-gray-800 rounded-md shadow-lg lg:right-auto lg:left-0">
                        <ul class="new-item-navigation">
                            {{ app('menu.newitems') }}
                        </ul>
                    </div>
                </div>
                @endif
                <div class="relative block h-6 lg:hidden">
                    <button x-on:click="menuOpen = !menuOpen" x-on:keydown.escape.window="menuOpen = false" x-on:click.away="menuOpen = false">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <ul x-cloak class="z-40 py-3 bg-gray-900 shadow-lg primary-navigation lg:block lg:shadow-none" x-bind:class="{'block absolute inset-x-0': menuOpen, 'hidden': !menuOpen}">

            {!! Menu::main() !!}

            <li><span class="separator">Content</span></li>

            {{ app('menu.primary') }}

            <li><span class="separator">Admin</span></li>

            {!! Menu::admin() !!}

            <li>
                <a role="button" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="mr-2 fas fa-fw fa-sign-out-alt"></i>Logout
                </a>
            </li>
        </ul>
    </nav>

    <main id="site-main" class="flex-1 w-full bg-gray-100 border-l">
        @yield('main')
    </main>

    <x-trov::notification />

    @if (session()->has('notification'))
    <x-trov::flash />
    @endif

    <!-- Logout Form -->
    <form id="logout-form" method="POST" action="{{ route('logout') }}">
        @csrf
    </form>

    <!-- Scripts -->
    @livewireScripts()
    <script src="https://media-library.cloudinary.com/global/all.js" defer></script>
    @stack('scripts')
    <script src="{{ asset('vendor/trov/js/solid.min.js') }}" defer></script>
    <script src="{{ asset('vendor/trov/js/fontawesome.min.js') }}" defer></script>
    <script src="{{ asset('vendor/trov/js/trov.js') }}" defer></script>
</body>

</html>