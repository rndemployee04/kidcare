<div class="flex min-h-screen">
    <x-layouts.app.sidebar :title="$title ?? null" />
    <main class="flex-1">
        {{ $slot }}
    </main>
</div>
@fluxScripts
