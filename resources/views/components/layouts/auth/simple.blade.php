<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
    <div class="bg-background flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-0
    bg-center bg-no-repeat bg-cover" style="background-image: url('{{ asset('images/bg1.jpg') }}');>
        <div class=" flex w-full max-w-[800px] mx-auto flex-col gap-2">
        <div class="flex flex-col gap-6">
            {{ $slot }}
        </div>
    </div>
    </div>
    @fluxScripts
</body>

</html>