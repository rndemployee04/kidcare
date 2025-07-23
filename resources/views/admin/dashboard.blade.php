@extends('admin.layouts.admin')
@section('content')
    <!-- Page Content -->
    <main class="flex-1 px-4 md:px-6 lg:px-8">
        <div class="py-6">
            <div class="mx-auto">
                <!-- Header -->
                <div class="bg-white shadow rounded-lg mb-6 p-4">
                    <h1 class="text-2xl font-bold text-gray-900">Admin Dashboard</h1>
                    <p class="mt-1 text-sm text-gray-500">Manage user verifications and approvals.</p>
                </div>

                <!-- Alerts -->
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p class="font-medium">Success!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p class="font-medium">Error!</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <!-- Pending Users -->
                <div class="bg-white shadow rounded-lg mb-6">
                    <div class="border-b border-gray-200 px-4 py-5 sm:px-6 bg-gray-50 rounded-t-lg">
                        <h2 class="text-lg font-medium text-gray-900">Pending Verification ({{ $pendingUsers->total() }})
                        </h2>
                    </div>

                    @if(count($pendingUsers) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            User</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Role</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pendingUsers as $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div
                                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500">
                                                        <span class="text-lg font-medium">{{ substr($user->name, 0, 1) }}</span>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'carebuddy' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <a href="{{ route('admin.viewApplication', $user->id) }}"
                                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">View
                                                        Application</a>
                                                    <a href="{{ route('admin.approve', $user->id) }}"
                                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Approve</a>
                                                    <a href="{{ route('admin.reject', $user->id) }}"
                                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Reject</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <div class="px-4 py-2">
                                        {{ $pendingUsers->links() }}
                                    </div>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="py-8 text-center text-gray-500 bg-gray-50 rounded-b-lg">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No pending verification requests</h3>
                            <p class="mt-1 text-sm text-gray-500">All verification requests have been processed.</p>
                        </div>
                    @endif
                </div>

                <!-- Approved Users -->
                <div class="bg-white shadow rounded-lg mb-6">
                    <div class="border-b border-gray-200 px-4 py-5 sm:px-6 bg-gray-50 rounded-t-lg">
                        <h2 class="text-lg font-medium text-gray-900">Approved Users ({{ $approvedUsers->total() }})</h2>
                    </div>

                    @if(count($approvedUsers) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            User</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Role</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($approvedUsers as $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div
                                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500">
                                                        <span class="text-lg font-medium">{{ substr($user->name, 0, 1) }}</span>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'carebuddy' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('admin.reject', $user->id) }}"
                                                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Revoke
                                                    Approval</a>
                                                <a href="{{ route('admin.viewApplication', $user->id) }}"
                                                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <div class="px-4 py-2">
                                        {{ $approvedUsers->links() }}
                                    </div>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="py-8 text-center text-gray-500 bg-gray-50 rounded-b-lg">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                </path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No approved users</h3>
                            <p class="mt-1 text-sm text-gray-500">Approve users to see them listed here.</p>
                        </div>
                    @endif
                </div>

                <!-- Rejected Users -->
                <div class="bg-white shadow rounded-lg">
                    <div class="border-b border-gray-200 px-4 py-5 sm:px-6 bg-gray-50 rounded-t-lg">
                        <h2 class="text-lg font-medium text-gray-900">Rejected Users ({{ $rejectedUsers->total() }})</h2>
                    </div>

                    @if(count($rejectedUsers) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            User</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Role</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($rejectedUsers as $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div
                                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500">
                                                        <span class="text-lg font-medium">{{ substr($user->name, 0, 1) }}</span>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'carebuddy' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('admin.approve', $user->id) }}"
                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Approve</a>
                                                <a href="{{ route('admin.viewApplication', $user->id) }}"
                                                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <div class="px-4 py-2">
                                        {{ $rejectedUsers->links() }}
                                    </div>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="py-8 text-center text-gray-500 bg-gray-50 rounded-b-lg">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                </path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No rejected users</h3>
                            <p class="mt-1 text-sm text-gray-500">All users have been approved or are pending verification.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection