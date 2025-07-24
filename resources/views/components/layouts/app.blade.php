{{-- resources/views/layouts/app.blade.php --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ($title ?? '') . ' | ' . config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    {!! ToastMagic::styles() !!}

    {{-- Initial theme setup to prevent Flash of Unstyled Content (FOUC) --}}
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="bg-gray-50 dark:bg-gray-900">

<!-- ========== HEADER ========== -->
<header class="sticky top-0 inset-x-0 flex flex-wrap md:justify-start md:flex-nowrap z-50 w-full bg-white border-b border-gray-200 text-sm py-3 sm:py-0 dark:bg-gray-800 dark:border-gray-700">
    <nav class="relative max-w-7xl w-full mx-auto px-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8" aria-label="Global">
        <div class="flex items-center justify-between">
            <a class="flex-none text-xl font-semibold dark:text-white" href="{{ route('dashboard') }}" aria-label="Brand">
                 <x-app-logo-icon class="h-8 w-auto fill-current text-black dark:text-white" />
            </a>
            <div class="sm:hidden">
                <button type="button" class="hs-collapse-toggle p-2 inline-flex justify-center items-center gap-2 rounded-lg border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-cyan-600 transition-all text-sm dark:bg-gray-800 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800" data-hs-overlay="#hs-application-sidebar" aria-controls="hs-application-sidebar" aria-label="Toggle navigation">
                    <svg class="hs-collapse-open:hidden size-4" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/></svg>
                    <svg class="hs-collapse-open:block hidden size-4" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>
                </button>
            </div>
        </div>
        <div class="flex flex-row items-center justify-end gap-2">
            <!-- Theme Switcher Button -->
            <button type="button" id="theme-switcher" class="size-9.5 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700">
                <svg id="theme-icon-light" class="hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="m17.66 17.66 1.41 1.41"></path><path d="M2 12h2"></path><path d="M20 12h2"></path><path d="m4.93 17.66 1.41-1.41"></path><path d="m17.66 4.93 1.41-1.41"></path></svg>
                <svg id="theme-icon-dark" class="hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path></svg>
            </button>
            <!-- End Theme Switcher Button -->

            <!-- Profile Dropdown -->
            <div class="hs-dropdown [--placement:bottom-right] relative inline-flex">
                <button id="hs-dropdown-account" type="button" class="w-full flex items-center justify-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 focus:outline-none disabled:opacity-50 disabled:pointer-events-none dark:text-white">
                    <span class="relative flex h-9 w-9 shrink-0 overflow-hidden rounded-full">
                        <span class="flex h-full w-full items-center justify-center rounded-full bg-gray-200 text-black dark:bg-gray-700 dark:text-white">
                            {{ auth()->user()->initials() }}
                        </span>
                    </span>
                </button>
                <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-white shadow-md rounded-lg mt-2 dark:bg-gray-800 dark:border dark:border-gray-700" role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-account">
                    <div class="py-3 px-5 bg-gray-100 rounded-t-lg dark:bg-gray-700">
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Signed in as') }}</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ auth()->user()->name }}</p>
                    </div>
                    <div class="p-1.5 space-y-0.5">
                        <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:bg-gray-700" href="{{ route('settings.profile') }}" wire:navigate>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.43.992a6.759 6.759 0 0 1 0 1.905c.008.379.137.75.43.99l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.512 6.512 0 0 1-.22.128c-.333.184-.582.496-.645.87l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.282c-.063-.374-.313-.686-.645-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.075-.124l-1.217.456a1.125 1.125 0 0 1-1.37-.49l-1.296-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.759 6.759 0 0 1 0-1.905c-.008-.379-.137-.75-.43-.99l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.49l1.217.456c.355.133.75.072 1.076-.124.072-.044.146-.087.22-.128.332-.184.582-.496.645-.87l.213-1.281z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" /></svg>
                            {{ __('Settings') }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                             <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="flex w-full items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:bg-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" /></svg>
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Profile Dropdown -->
        </div>
    </nav>
</header>
<!-- ========== END HEADER ========== -->

@include('layouts.partials.sidebar')

<!-- Content -->
<div class="w-full pt-10 px-4 sm:px-6 md:px-8 lg:ps-72">
    <main>
        @if (isset($title))
            <header>
                <h1 class="block text-2xl font-bold text-gray-800 sm:text-3xl dark:text-white">{{ $title }}</h1>
            </header>
        @endif
        <div class="mt-8">
             {{ $slot }}
        </div>
    </main>
</div>
<!-- End Content -->

@livewireScripts
{!! ToastMagic::scripts() !!}

<script>
    const themeSwitcher = {
        init: function() {
            this.switcher = document.getElementById('theme-switcher');
            this.lightIcon = document.getElementById('theme-icon-light');
            this.darkIcon = document.getElementById('theme-icon-dark');
            if (!this.switcher) { return; }
            this.theme = this.getTheme();
            this.applyTheme();
            this.switcher.addEventListener('click', () => this.toggleTheme());
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                if (!('theme' in localStorage)) {
                    this.theme = e.matches ? 'dark' : 'light';
                    this.applyTheme();
                }
            });
        },
        getTheme: function() {
            if (localStorage.getItem('theme')) {
                return localStorage.getItem('theme');
            }
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        },
        applyTheme: function() {
            if (this.theme === 'dark') {
                document.documentElement.classList.add('dark');
                if(this.lightIcon) this.lightIcon.classList.add('hidden');
                if(this.darkIcon) this.darkIcon.classList.remove('hidden');
            } else {
                document.documentElement.classList.remove('dark');
                if(this.lightIcon) this.lightIcon.classList.remove('hidden');
                if(this.darkIcon) this.darkIcon.classList.add('hidden');
            }
        },
        toggleTheme: function() {
            this.theme = (this.theme === 'light') ? 'dark' : 'light';
            localStorage.setItem('theme', this.theme);
            this.applyTheme();
        }
    };

    function initializeAllScripts() {
        if (window.HSStaticMethods) {
            window.HSStaticMethods.autoInit();
        }
        themeSwitcher.init();
    }

    document.addEventListener('DOMContentLoaded', initializeAllScripts);
    
    document.addEventListener('livewire:navigated', initializeAllScripts);
</script>

</body>
</html>