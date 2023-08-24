<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $metaTitle ?: 'Brance Blogs' }}</title>
    <meta name="author" content="Brian">
    <meta name="description" content="{{ $metaDescription }}">

    <!-- Tailwind -->

    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
    </style>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"
        integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous">
    </script>

    @livewireStyles
    @vite('resources/css/app.css')
</head>

<body class="bg-white font-family-karla h-full min-h-screen ">

    <!-- Top Bar Nav -->
    <nav class="w-full py-4 bg-blue-800 shadow">
        <div class="w-full container mx-auto flex flex-wrap items-center justify-between">

            <nav>
                <ul class="flex items-center justify-between font-bold text-sm text-white uppercase no-underline">
                    <li><a class="hover:text-gray-200 px-4" href="/">Brance</a></li>

                </ul>
            </nav>


        </div>

    </nav>

    <!-- Text Header -->
    <header class="w-full container mx-auto">
        <div class="flex flex-col items-center py-12">
            <a class="font-bold text-gray-800 uppercase hover:text-gray-700 text-5xl" href="/">
                {{ \App\Models\TextWidget::getTitle('website-top-header') }}
            </a>
            <p class="text-lg text-gray-600">
                {{ \App\Models\TextWidget::getTitle('header') }}
            </p>
        </div>
    </header>

    <!-- Topic Nav -->
    <nav class="w-full py-4 border-t border-b bg-gray-100" x-data="{ open: false }">
        <div class="block sm:hidden">
            <a href="#"
                class="block md:hidden text-base font-bold uppercase text-center flex justify-center items-center"
                @click="open = !open">
                Topics <i :class="open ? 'fa-chevron-down': 'fa-chevron-up'" class="fas ml-2"></i>
            </a>
        </div>
        <div :class="open ? 'block': 'hidden'" class="w-full flex-grow sm:flex sm:items-center sm:w-auto">
            <div :class="open ? 'block': 'hidden'" class="w-full flex-grow sm:flex sm:items-center sm:w-auto">
                <div :class="open ? 'block': 'hidden'" class="w-full flex-grow sm:flex sm:items-center sm:w-auto">
                    <div
                        class="w-full container mx-auto flex flex-col sm:flex-row items-center justify-between text-sm font-bold uppercase mt-0 px-6 py-2">
                        <div class="flex flex-col sm:flex-row items-center">
                            <!-- Wrap the nav links in a flex container -->
                            <a href="/"
                                class="bg-black text-white rounded py-2 px-4 mx-2 flex flex-row items-center  sm:justify-start">Home</a>
                            @foreach ($categories as $index => $category)
                            <a href="{{ route('by-category', $category) }}" class="rounded py-2 px-4 mx-2 {{ optional(request('category'))->slug ==  $category->slug ? 'bg-blue-600 text-white' : ''}} 
                                @if(request('category') == null) hover-effect @endif
                                @if ($index > 0)  @endif">
                                <!-- Add mt-2 to create space between the links -->
                                {{ $category->title }}
                            </a>
                            @endforeach
                            <a href="/about-us" class="text-black rounded py-2 px-4 mx-2">About us</a>
                        </div>
                        <div class="flex mt-4 sm:mt-0">
                            <!-- Wrap the auth and dropdown in a flex container -->
                            @auth
                            <div x-data="{ isOpen: false }" class="relative inline-block text-left">
                                <div>
                                    <button @click="isOpen = !isOpen" type="button"
                                        class="bg-black rounded text-white flex py-2 px-4 mx-2" id="menu-button"
                                        :aria-expanded="isOpen" aria-haspopup="true">
                                        {{ Auth::user()->name }}
                                        <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                                            aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Dropdown menu, show/hide based on x-data "isOpen" state -->
                                <div x-show="isOpen" @click.away="isOpen = false" @keydown.escape="isOpen = false"
                                    class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    role="menu" aria-orientation="vertical"
                                    :aria-labelledby="isOpen ? 'menu-button' : null" tabindex="-1">
                                    <div class="py-1" role="none">
                                        <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                                        <a href="{{ route('profile.edit')}}"
                                            class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
                                            id="menu-item-0">{{ __('Profile') }}</a>

                                        <form method="POST" action="{{ route('logout') }}" role="none">
                                            @csrf
                                            <button type="submit"
                                                class="text-gray-700 block w-full px-4 py-2 text-left text-sm"
                                                role="menuitem" tabindex="-1" id="menu-item-3">{{ __('Log Out') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @else
                            <a href="{{ route('login') }}"
                                class="bg-blue-800 text-white rounded py-2 px-4 mx-2">Login</a>
                            <a href="{{ ('register') }}"
                                class="bg-blue-800 text-white rounded py-2 px-4 mx-2">Register</a>
                            @endauth
                        </div>
                    </div>
                </div>




            </div>

        </div>

        </div>
    </nav>


    <div class="container mx-auto  flex  flex-wrap py-6">

        {{ $slot }}

    </div>

    <footer class="w-full border-t bg-blue-800 pb-12">



        <div class="w-full container mx-auto flex flex-col items-center">

            <div class="uppercase pt-6">&copy; myblog.com</div>
        </div>
    </footer>


    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/64d48517cc26a871b02e61c8/1h7f2fpmr';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->
    @livewireScripts

</body>

</html>