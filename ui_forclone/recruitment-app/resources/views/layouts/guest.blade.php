<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased bg-slate-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-slate-100 via-white to-indigo-50/30">
            <div class="animate-fadeIn">
                <a href="/">
                    <x-application-logo class="w-24 h-24 fill-current text-slate-900 drop-shadow-sm" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-8 px-8 py-10 bg-white shadow-[0_20px_50px_rgba(15,23,42,0.1)] overflow-hidden sm:rounded-2xl border border-slate-100 animate-fadeIn">
                {{ $slot }}
            </div>

            <div class="mt-8 text-center animate-fadeIn" style="animation-delay: 0.2s">
                <p class="text-sm text-slate-400 font-medium tracking-wide">&copy; {{ date('Y') }} CMFI Bilingual High School. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>
