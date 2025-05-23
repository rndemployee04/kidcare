@extends('admin.layouts.admin')
@section('content')
    <div class="container mx-auto py-8">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4">User Application Details</h2>
            <div class="mb-4">
                <strong>Name:</strong> {{ $user->name }}<br>
                <strong>Email:</strong> {{ $user->email }}<br>
                <strong>Role:</strong> {{ ucfirst($user->role) }}<br>
                <strong>Registration Complete:</strong> {{ $user->registration_complete ? 'Yes' : 'No' }}<br>
                <strong>Verification Status:</strong> {{ ucfirst($user->verification_status) }}<br>
            </div>
            @if($user->role === 'carebuddy' && $user->careBuddy)
    <div class="mb-4 p-4 bg-gray-50 rounded-lg">
        <h3 class="font-semibold mb-2 text-lg text-blue-700">Carebuddy Profile</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><strong>Phone:</strong> {{ $user->careBuddy->phone ?? '-' }}</div>
            <div><strong>Date of Birth:</strong> {{ $user->careBuddy->dob ?? '-' }}</div>
            <div><strong>Gender:</strong> {{ ucfirst($user->careBuddy->gender ?? '-') }}</div>
            <div><strong>Background Check Consent:</strong> {{ $user->careBuddy->background_check_consent ? 'Yes' : 'No' }}</div>
            <div class="md:col-span-2"><strong>Permanent Address:</strong> {{ $user->careBuddy->permanent_address ?? '-' }}</div>
            <div class="md:col-span-2"><strong>Current Address:</strong> {{ $user->careBuddy->current_address ?? '-' }}</div>
            <div><strong>City:</strong> {{ $user->careBuddy->city ?? '-' }}</div>
            <div><strong>State:</strong> {{ $user->careBuddy->state ?? '-' }}</div>
            <div><strong>Zip:</strong> {{ $user->careBuddy->zip ?? '-' }}</div>
        </div>
        @if($user->careBuddy->profile_photo)
            <div class="mt-4">
                <strong>Profile Photo:</strong><br>
                <img src="{{ asset('storage/' . $user->careBuddy->profile_photo) }}" alt="Profile Photo" class="h-24 w-24 rounded-full object-cover border mt-2">
            </div>
        @endif
    </div>
            @elseif($user->role === 'parent' && $user->parentProfile)
    <div class="mb-4 p-4 bg-gray-50 rounded-lg">
        <h3 class="font-semibold mb-2 text-lg text-purple-700">Parent Profile</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><strong>Phone:</strong> {{ $user->parentProfile->phone ?? '-' }}</div>
            <div><strong>Date of Birth:</strong> {{ $user->parentProfile->dob ?? '-' }}</div>
            <div><strong>Gender:</strong> {{ ucfirst($user->parentProfile->gender ?? '-') }}</div>
            <div class="md:col-span-2"><strong>Permanent Address:</strong> {{ $user->parentProfile->permanent_address ?? '-' }}</div>
            <div class="md:col-span-2"><strong>Current Address:</strong> {{ $user->parentProfile->current_address ?? '-' }}</div>
            <div><strong>City:</strong> {{ $user->parentProfile->city ?? '-' }}</div>
            <div><strong>State:</strong> {{ $user->parentProfile->state ?? '-' }}</div>
            <div><strong>Zip:</strong> {{ $user->parentProfile->zip ?? '-' }}</div>
        </div>
        @if($user->parentProfile->profile_photo)
            <div class="mt-4">
                <strong>Profile Photo:</strong><br>
                <img src="{{ asset('storage/' . $user->parentProfile->profile_photo) }}" alt="Profile Photo" class="h-24 w-24 rounded-full object-cover border mt-2">
            </div>
        @endif
    </div>
            @endif
            <div class="flex space-x-4 mt-6">
                <a href="{{ route('admin.approve', $user->id) }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Approve</a>
                <a href="{{ route('admin.reject', $user->id) }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Reject</a>
                <a href="{{ route('admin.dashboard') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Back to Dashboard</a>
            </div>
        </div>
    </div>
@endsection