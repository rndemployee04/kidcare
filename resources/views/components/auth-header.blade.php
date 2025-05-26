@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-left">
    <flux:heading size="xl">{{ $title }}</flux:heading>
    <flux:subheading>{{ $description }}</flux:subheading>
</div>
