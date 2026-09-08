<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ProjectHub') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col sm:justify-center items-center px-4 py-10">

        {{-- Logo --}}
        <a href="/" class="flex items-center gap-2.5 mb-8">
            <div
                class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-sm shadow-indigo-600/30">
                <span class="text-white font-bold text-sm tracking-tight">PH</span>
            </div>
            <span class="font-semibold text-gray-900 text-lg">ProjectHub</span>
        </a>

        {{-- Card --}}
        <div class="w-full sm:max-w-md bg-white rounded-2xl shadow-sm ring-1 ring-gray-950/5 overflow-hidden">
            <div class="h-1 bg-gradient-to-r from-indigo-500 to-violet-500"></div>
            <div class="px-6 py-8 sm:px-8">
                {{ $slot }}
            </div>
        </div>

        <p class="mt-6 text-center text-xs text-gray-400">
            <a href="/" class="hover:text-indigo-600 transition">← Back to home</a>
        </p>
    </div>
</body>

</html>
