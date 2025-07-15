@extends('admin.layouts.admin')
@section('content')
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-6 mb-8 rounded-lg shadow-md transition-all duration-300 ease-in-out" role="alert">
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-6 mb-8 rounded-lg shadow-md transition-all duration-300 ease-in-out" role="alert">
            <p class="text-sm font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-2xl p-8 transform transition-all duration-300 hover:shadow-2xl">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6 tracking-tight">User Application Details</h2>
            <div class="mb-8 bg-gray-50 p-6 rounded-xl border border-gray-200">
                <div class="grid grid-cols-1 gap-4 text-gray-700">
                    <p><strong class="font-semibold text-gray-900">Name:</strong> {{ $user->name }}</p>
                    <p><strong class="font-semibold text-gray-900">Email:</strong> {{ $user->email }}</p>
                    <p><strong class="font-semibold text-gray-900">Role:</strong> {{ ucfirst($user->role) }}</p>
                    <p><strong class="font-semibold text-gray-900">Registration Complete:</strong> {{ $user->registration_complete ? 'Yes' : 'No' }}</p>
                    <p><strong class="font-semibold text-gray-900">Verification Status:</strong> {{ ucfirst($user->verification_status) }}</p>
                </div>
            </div>

            {{-- CAREBUDDY SECTION --}}
            @if($user->role === 'carebuddy' && $user->careBuddy)
                <div class="mb-8 p-6 bg-gradient-to-r from-blue-50 to-gray-50 rounded-xl border border-blue-100 transition-all duration-300 hover:shadow-lg">
                    <h3 class="font-bold text-xl text-blue-800 mb-4">Carebuddy Profile</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
                        <div><strong class="font-semibold text-gray-900">Phone:</strong> {{ $user->careBuddy->phone ?? '-' }}</div>
                        <div><strong class="font-semibold text-gray-900">Date of Birth:</strong> {{ $user->careBuddy->dob ?? '-' }}</div>
                        <div><strong class="font-semibold text-gray-900">Gender:</strong> {{ ucfirst($user->careBuddy->gender ?? '-') }}</div>
                        <div><strong class="font-semibold text-gray-900">Background Check Consent:</strong>
                            {{ $user->careBuddy->background_check_consent ? 'Yes' : 'No' }}</div>
                        <div class="md:col-span-2"><strong class="font-semibold text-gray-900">Permanent Address:</strong>
                            {{ $user->careBuddy->permanent_address ?? '-' }}</div>
                        <div class="md:col-span-2"><strong class="font-semibold text-gray-900">Current Address:</strong>
                            {{ $user->careBuddy->current_address ?? '-' }}</div>
                        <div><strong class="font-semibold text-gray-900">City:</strong> {{ $user->careBuddy->city ?? '-' }}</div>
                        <div><strong class="font-semibold text-gray-900">State:</strong> {{ $user->careBuddy->state ?? '-' }}</div>
                        <div><strong class="font-semibold text-gray-900">Zip:</strong> {{ $user->careBuddy->zip ?? '-' }}</div>
                    </div>
                    @if($user->careBuddy->profile_photo)
                        <div class="mt-6">
                            <strong class="font-semibold text-gray-900">Profile Photo:</strong><br>
                            <img src="{{ asset('storage/' . $user->careBuddy->profile_photo) }}" alt="Profile Photo"
                                 class="h-28 w-28 rounded-full object-cover border-4 border-blue-200 mt-3 shadow-sm hover:scale-105 transition-transform duration-300">
                        </div>
                    @endif
                </div>
            @endif

            {{-- PARENT SECTION --}}
            @if($user->role === 'parent' && $user->parentProfile)
                <div class="mb-8 p-6 bg-gradient-to-r from-purple-50 to-gray-50 rounded-xl border border-purple-100 transition-all duration-300 hover:shadow-lg">
                    <h3 class="font-bold text-xl text-purple-800 mb-4">Parent Profile</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
                        @if($user->parentProfile->phone)
                            <div><strong class="font-semibold text-gray-900">Phone:</strong> {{ $user->parentProfile->phone }}</div>
                        @endif
                        @if($user->parentProfile->dob)
                            <div><strong class="font-semibold text-gray-900">Date of Birth:</strong> {{ $user->parentProfile->dob }}</div>
                        @endif
                        @if($user->parentProfile->gender)
                            <div><strong class="font-semibold text-gray-900">Gender:</strong> {{ ucfirst($user->parentProfile->gender) }}</div>
                        @endif
                        @if($user->parentProfile->permanent_address)
                            <div class="md:col-span-2"><strong class="font-semibold text-gray-900">Permanent Address:</strong>
                                {{ $user->parentProfile->permanent_address }}</div>
                        @endif
                        @if($user->parentProfile->current_address)
                            <div class="md:col-span-2"><strong class="font-semibold text-gray-900">Current Address:</strong>
                                {{ $user->parentProfile->current_address }}</div>
                        @endif
                        @if($user->parentProfile->city)
                            <div><strong class="font-semibold text-gray-900">City:</strong> {{ $user->parentProfile->city }}</div>
                        @endif
                        @if($user->parentProfile->state)
                            <div><strong class="font-semibold text-gray-900">State:</strong> {{ $user->parentProfile->state }}</div>
                        @endif
                        @if($user->parentProfile->zip)
                            <div><strong class="font-semibold text-gray-900">Zip:</strong> {{ $user->parentProfile->zip }}</div>
                        @endif
                        @if($user->parentProfile->profession)
                            <div><strong class="font-semibold text-gray-900">Profession:</strong> {{ $user->parentProfile->profession }}</div>
                        @endif
                        @if($user->parentProfile->spouse_name)
                            <div><strong class="font-semibold text-gray-900">Spouse Name:</strong> {{ $user->parentProfile->spouse_name }}</div>
                        @endif
                        @if($user->parentProfile->spouse_email)
                            <div><strong class="font-semibold text-gray-900">Spouse Email:</strong> {{ $user->parentProfile->spouse_email }}</div>
                        @endif
                        @if($user->parentProfile->spouse_phone)
                            <div><strong class="font-semibold text-gray-900">Spouse Phone:</strong> {{ $user->parentProfile->spouse_phone }}</div>
                        @endif
                        @if($user->parentProfile->spouse_profession)
                            <div><strong class="font-semibold text-gray-900">Spouse Profession:</strong> {{ $user->parentProfile->spouse_profession }}</div>
                        @endif
                        @if($user->parentProfile->monthly_income)
                            <div><strong class="font-semibold text-gray-900">Monthly Income:</strong> {{ $user->parentProfile->monthly_income }}</div>
                        @endif
                        @if($user->parentProfile->number_of_children)
                            <div><strong class="font-semibold text-gray-900">Number of Children:</strong> {{ $user->parentProfile->number_of_children }}</div>
                        @endif
                        @if($user->parentProfile->number_needing_care)
                            <div><strong class="font-semibold text-gray-900">Number Needing Care:</strong> {{ $user->parentProfile->number_needing_care }}</div>
                        @endif
                        @if($user->parentProfile->preferred_drop_off_time)
                            <div><strong class="font-semibold text-gray-900">Preferred Drop-off Time:</strong> {{ $user->parentProfile->preferred_drop_off_time }}</div>
                        @endif
                        @if($user->parentProfile->preferred_type_of_caregiver)
                            <div><strong class="font-semibold text-gray-900">Preferred Type of Caregiver:</strong> {{ $user->parentProfile->preferred_type_of_caregiver }}</div>
                        @endif
                        @if($user->parentProfile->preferred_radius)
                            <div><strong class="font-semibold text-gray-900">Preferred Radius:</strong> {{ $user->parentProfile->preferred_radius }}</div>
                        @endif
                        @if($user->parentProfile->needs_special_needs_support !== null)
                            <div><strong class="font-semibold text-gray-900">Needs Special Needs Support:</strong>
                                {{ $user->parentProfile->needs_special_needs_support ? 'Yes' : 'No' }}</div>
                        @endif
                        @if($user->parentProfile->reason_for_service)
                            <div class="md:col-span-2"><strong class="font-semibold text-gray-900">Reason for Service:</strong>
                                {{ $user->parentProfile->reason_for_service }}</div>
                        @endif
                        @if($user->parentProfile->emergency_contact_name)
                            <div><strong class="font-semibold text-gray-900">Emergency Contact Name:</strong> {{ $user->parentProfile->emergency_contact_name }}</div>
                        @endif
                        @if($user->parentProfile->emergency_contact_phone)
                            <div><strong class="font-semibold text-gray-900">Emergency Contact Phone:</strong> {{ $user->parentProfile->emergency_contact_phone }}</div>
                        @endif
                        @if($user->parentProfile->terms_accepted !== null)
                            <div><strong class="font-semibold text-gray-900">Terms Accepted:</strong>
                                {{ $user->parentProfile->terms_accepted ? 'Yes' : 'No' }}</div>
                        @endif
                        @if($user->parentProfile->children_ages && is_array($user->parentProfile->children_ages))
                            <div class="md:col-span-2"><strong class="font-semibold text-gray-900">Children Ages:</strong>
                                {{ implode(', ', $user->parentProfile->children_ages) }}</div>
                        @endif
                    </div>
                    @if($user->parentProfile->profile_photo)
                        <div class="mt-6">
                            <strong class="font-semibold text-gray-900">Profile Photo:</strong><br>
                            <img src="{{ asset('storage/' . $user->parentProfile->profile_photo) }}" alt="Profile Photo"
                                 class="h-28 w-28 rounded-full object-cover border-4 border-purple-200 mt-3 shadow-sm hover:scale-105 transition-transform duration-300">
                        </div>
                    @endif
                    @if($user->parentProfile->id_proof_path)
                        <div class="mt-6">
                            <strong class="font-semibold text-gray-900">ID Proof:</strong><br>
                            <a href="{{ asset('storage/' . $user->parentProfile->id_proof_path) }}"
                               class="text-purple-600 hover:text-purple-800 underline transition-colors duration-200" target="_blank">View Document</a>
                        </div>
                    @endif
                </div>
            @endif

            {{-- PLAYPAL SECTION --}}
            @if($user->role === 'playpal' && $user->playPal)
                <div class="mb-8 p-6 bg-gradient-to-r from-teal-50 to-gray-50 rounded-xl border border-teal-100 transition-all duration-300 hover:shadow-lg">
                    <h3 class="font-bold text-xl text-teal-800 mb-4">PlayPal Profile</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
                        <div><strong class="font-semibold text-gray-900">Phone:</strong> {{ $user->playPal->phone ?? '-' }}</div>
                        <div><strong class="font-semibold text-gray-900">Date of Birth:</strong> {{ $user->playPal->dob ?? '-' }}</div>
                        <div><strong class="font-semibold text-gray-900">Gender:</strong> {{ ucfirst($user->playPal->gender ?? '-') }}</div>
                        <div><strong class="font-semibold text-gray-900">Category:</strong> {{ $user->playPal->category ?? '-' }}</div>
                        <div><strong class="font-semibold text-gray-900">Service Radius:</strong> {{ $user->playPal->service_radius ?? '-' }}</div>
                        <div><strong class="font-semibold text-gray-900">Child Age Limit:</strong> {{ $user->playPal->child_age_limit ?? '-' }}</div>
                        <div><strong class="font-semibold text-gray-900">Willing to Take Insurance:</strong>
                            {{ $user->playPal->willing_to_take_insurance ? 'Yes' : 'No' }}</div>
                        <div><strong class="font-semibold text-gray-900">Background Check Consent:</strong>
                            {{ $user->playPal->background_check_consent ? 'Yes' : 'No' }}</div>
                        <div><strong class="font-semibold text-gray-900">Terms Accepted:</strong>
                            {{ $user->playPal->terms_accepted ? 'Yes' : 'No' }}</div>
                        <div><strong class="font-semibold text-gray-900">Availability:</strong>
                            @if(is_array($user->playPal->availability))
                                {{ implode(', ', $user->playPal->availability) }}
                            @else
                                {{ $user->playPal->availability ?? '-' }}
                            @endif
                        </div>
                        <div class="md:col-span-2"><strong class="font-semibold text-gray-900">Permanent Address:</strong>
                            {{ $user->playPal->permanent_address ?? '-' }}</div>
                        <div class="md:col-span-2"><strong class="font-semibold text-gray-900">Current Address:</strong>
                            {{ $user->playPal->current_address ?? '-' }}</div>
                        <div><strong class="font-semibold text-gray-900">City:</strong> {{ $user->playPal->city ?? '-' }}</div>
                        <div><strong class="font-semibold text-gray-900">State:</strong> {{ $user->playPal->state ?? '-' }}</div>
                        <div><strong class="font-semibold text-gray-900">Zip:</strong> {{ $user->playPal->zip ?? '-' }}</div>
                    </div>

                    {{-- File Uploads --}}
                    <div class="mt-6 space-y-4">
                        @if($user->playPal->profile_photo)
                            <div>
                                <strong class="font-semibold text-gray-900">Profile Photo:</strong><br>
                                <img src="{{ asset('storage/' . $user->playPal->profile_photo) }}" alt="Profile Photo"
                                     class="h-28 w-28 rounded-full object-cover border-4 border-teal-200 mt-3 shadow-sm hover:scale-105 transition-transform duration-300">
                            </div>
                        @endif

                        @if($user->playPal->id_proof_path)
                            <div>
                                <strong class="font-semibold text-gray-900">ID Proof:</strong><br>
                                <a href="{{ asset('storage/' . $user->playPal->id_proof_path) }}"
                                   class="text-teal-600 hover:text-teal-800 underline transition-colors duration-200" target="_blank">View Document</a>
                            </div>
                        @endif

                        @if($user->playPal->selfie_path)
                            <div>
                                <strong class="font-semibold text-gray-900">Selfie with ID:</strong><br>
                                <img src="{{ asset('storage/' . $user->playPal->selfie_path) }}" alt="Selfie"
                                     class="h-28 w-28 rounded object-cover border-4 border-teal-200 mt-3 shadow-sm hover:scale-105 transition-transform duration-300">
                            </div>
                        @endif

                        @if($user->playPal->certificate_path)
                            <div>
                                <strong class="font-semibold text-gray-900">Professional Certificate:</strong><br>
                                <a href="{{ asset('storage/' . $user->playPal->certificate_path) }}"
                                   class="text-teal-600 hover:text-teal-800 underline transition-colors duration-200" target="_blank">View Document</a>
                            </div>
                        @endif

                        @if($user->playPal->marriage_certificate_path)
                            <div>
                                <strong class="font-semibold text-gray-900">Marriage Certificate:</strong><br>
                                <a href="{{ asset('storage/' . $user->playPal->marriage_certificate_path) }}"
                                   class="text-teal-600 hover:text-teal-800 underline transition-colors duration-200" target="_blank">View Document</a>
                            </div>
                        @endif

                        @if($user->playPal->birth_certificate_path)
                            <div>
                                <strong class="font-semibold text-gray-900">Birth Certificate:</strong><br>
                                <a href="{{ asset('storage/' . $user->playPal->birth_certificate_path) }}"
                                   class="text-teal-600 hover:text-teal-800 underline transition-colors duration-200" target="_blank">View Document</a>
                            </div>
                        @endif

                        @if($user->playPal->child_birth_certificate_path)
                            <div>
                                <strong class="font-semibold text-gray-900">Child Birth Certificate:</strong><br>
                                <a href="{{ asset('storage/' . $user->playPal->child_birth_certificate_path) }}"
                                   class="text-teal-600 hover:text-teal-800 underline transition-colors duration-200" target="_blank">View Document</a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Action Buttons --}}
            <div class="flex flex-wrap gap-4 mt-8">
                @if($user->verification_status == 'pending')
                    <a href="{{ route('admin.approve', $user->id) }}"
                       class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 ease-in-out transform hover:-translate-y-1 shadow-md">Approve</a>
                    <a href="{{ route('admin.reject', $user->id) }}"
                       class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 ease-in-out transform hover:-translate-y-1 shadow-md">Reject</a>
                @elseif($user->verification_status == 'approved')
                    <span class="bg-green-100 text-green-800 px-6 py-3 rounded-lg font-medium shadow-sm">Approved</span>
                @elseif($user->verification_status == 'rejected')
                    <span class="bg-red-100 text-red-800 px-6 py-3 rounded-lg font-medium shadow-sm">Rejected</span>
                @endif
                <a href="{{ route('admin.dashboard') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-medium transition-all duration-200 ease-in-out transform hover:-translate-y-1 shadow-md">Back to Dashboard</a>
            </div>
        </div>
    </div>
@endsection