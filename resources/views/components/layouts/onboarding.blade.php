<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Continue Registration' }}</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @livewireStyles
</head>

<body class="min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-900 dark:text-white">
    <div class="min-h-screen flex flex-col items-center justify-start py-12 px-6 bg-gradient-to-r from-[#fff6eb] to-[#ebfffe] ">
        <div class="w-full max-w-4xl ">
            {{ $slot }}
        </div>
    </div>
    @livewireScripts
</body>

</html>
