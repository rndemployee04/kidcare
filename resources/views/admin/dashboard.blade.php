<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
    @endif
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
            <h2 class="text-xl font-semibold mb-2">Pending Applications</h2>
            <ul>
                @forelse ($pendingUsers as $user)
                    <li class="bg-white dark:bg-zinc-800 p-4 rounded shadow mb-2 flex flex-col gap-2">
                        <span class="font-bold">{{ $user->name }}</span>
                        <span class="text-sm">{{ $user->email }}</span>
                        <span class="text-xs capitalize">Role: {{ $user->role }}</span>
                        <div class="flex gap-2 mt-2">
                            <button wire:click="approve({{ $user->id }})" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded cursor-pointer">Approve</button>
                            <button wire:click="reject({{ $user->id }})" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded cursor-pointer">Reject</button>
                        </div>
                    </li>
                @empty
                    <li class="text-gray-500">No pending applications.</li>
                @endforelse
            </ul>
        </div>
        <div>
            <h2 class="text-xl font-semibold mb-2">Approved Applications</h2>
            <ul>
                @forelse ($approvedUsers as $user)
                    <li class="bg-white dark:bg-zinc-800 p-4 rounded shadow mb-2 flex flex-col gap-1">
                        <span class="font-bold">{{ $user->name }}</span>
                        <span class="text-sm">{{ $user->email }}</span>
                        <span class="text-xs capitalize">Role: {{ $user->role }}</span>
                    </li>
                @empty
                    <li class="text-gray-500">No approved applications.</li>
                @endforelse
            </ul>
        </div>
        <div>
            <h2 class="text-xl font-semibold mb-2">Rejected Applications</h2>
            <ul>
                @forelse ($rejectedUsers as $user)
                    <li class="bg-white dark:bg-zinc-800 p-4 rounded shadow mb-2 flex flex-col gap-1">
                        <span class="font-bold">{{ $user->name }}</span>
                        <span class="text-sm">{{ $user->email }}</span>
                        <span class="text-xs capitalize">Role: {{ $user->role }}</span>
                    </li>
                @empty
                    <li class="text-gray-500">No rejected applications.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
