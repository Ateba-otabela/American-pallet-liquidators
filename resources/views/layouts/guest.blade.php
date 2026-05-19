<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'American Pallet Liquidators') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Outfit', sans-serif;
            }
        </style>
    </head>
    <body class="bg-zinc-50 text-slate-800 antialiased min-h-screen flex flex-col justify-center items-center p-4">
        
        <!-- Brand Logo Header -->
        <div class="mb-8">
            <a href="/" class="flex items-center gap-2 group justify-center">
                <span class="bg-zinc-950 text-white px-3 py-1.5 rounded font-black text-xl tracking-tight shadow">APL</span>
                <div class="flex flex-col text-left">
                    <span class="text-zinc-900 font-extrabold text-lg leading-none tracking-tight">AMERICAN PALLET</span>
                    <span class="text-zinc-500 font-bold text-xs uppercase tracking-widest leading-none mt-0.5">LIQUIDATORS</span>
                </div>
            </a>
        </div>

        <!-- Auth Card -->
        <div class="w-full sm:max-w-md bg-white border border-gray-200 p-6 sm:p-8 rounded-xl shadow-sm space-y-6">
            {{ $slot }}
        </div>

        <!-- Home back link -->
        <a href="/" class="text-xs font-bold text-zinc-500 hover:text-zinc-950 transition uppercase tracking-wider mt-6">
            &larr; Return to Storefront
        </a>

    </body>
</html>
