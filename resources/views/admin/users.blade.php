@extends('admin.layouts.admin')

@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-bold mb-6">User Management</h2>

        {{-- Custom Tabs --}}
        <div x-data="{ tab: 'playpals' }">
            <div class="flex space-x-4 border-b border-gray-300 mb-4">
                <button class="px-4 py-2 text-sm font-semibold"
                    :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === 'playpals' }"
                    @click="tab = 'playpals'">PlayPals</button>

                <button class="px-4 py-2 text-sm font-semibold"
                    :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === 'parents' }"
                    @click="tab = 'parents'">Parents</button>
            </div>

            {{-- PlayPals Tab --}}
            <div x-show="tab === 'playpals'" class="overflow-x-auto">
                <table class="min-w-full bg-white border">
                    <thead class="bg-gray-100 text-left text-sm text-gray-600 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-2 border">Name</th>
                            <th class="px-4 py-2 border">Email</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Registered At</th>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($playpals as $user)
                            <tr>
                                <td class="px-4 py-2 border">{{ $user->name }}</td>
                                <td class="px-4 py-2 border">{{ $user->email }}</td>
                                <td class="px-4 py-2 border capitalize">{{ $user->verification_status }}</td>
                                <td class="px-4 py-2 border">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-2 border space-x-2">
                                    {{-- View --}}
                                    <a href="{{ route('admin.viewApplication', $user->id) }}"
                                        class="text-blue-600 hover:underline" title="View Application">View</a>

                                    {{-- Approve / Revoke --}}
                                    @if($user->verification_status !== 'approved')
                                        <a href="{{ route('admin.approve', $user->id) }}" class="text-green-600 hover:underline"
                                            title="Approve">Approve</a>
                                    @else
                                        <a href="{{ route('admin.reject', $user->id) }}" class="text-yellow-600 hover:underline"
                                            title="Revoke">Revoke</a>
                                    @endif

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.delete', $user->id) }}" method="POST" class="inline-block"
                                        onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline" title="Delete">Delete</button>
                                    </form>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-500">No PlayPals found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Parents Tab --}}
            <div x-show="tab === 'parents'" class="overflow-x-auto">
                <table class="min-w-full bg-white border">
                    <thead class="bg-gray-100 text-left text-sm text-gray-600 uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-2 border">Name</th>
                            <th class="px-4 py-2 border">Email</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Registered At</th>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($parents as $user)
                            <tr>
                                <td class="px-4 py-2 border">{{ $user->name }}</td>
                                <td class="px-4 py-2 border">{{ $user->email }}</td>
                                <td class="px-4 py-2 border capitalize">{{ $user->verification_status }}</td>
                                <td class="px-4 py-2 border">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-2 border space-x-2">
                                    {{-- View --}}
                                    <a href="{{ route('admin.viewApplication', $user->id) }}"
                                        class="text-blue-600 hover:underline" title="View Application">View</a>

                                    {{-- Approve / Revoke --}}
                                    @if($user->verification_status !== 'approved')
                                        <a href="{{ route('admin.approve', $user->id) }}" class="text-green-600 hover:underline"
                                            title="Approve">Approve</a>
                                    @else
                                        <a href="{{ route('admin.reject', $user->id) }}" class="text-yellow-600 hover:underline"
                                            title="Revoke">Revoke</a>
                                    @endif

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.delete', $user->id) }}" method="POST" class="inline-block"
                                        onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline" title="Delete">Delete</button>
                                    </form>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-500">No Parents found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection