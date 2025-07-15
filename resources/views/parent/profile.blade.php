<x-parent.layouts.parent-layout>
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow mt-8">
        <h2 class="text-2xl font-bold mb-6">My Profile</h2>

        @if (session('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('parent.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Profile Photo --}}
            <div class="flex items-center mb-6">
                <div class="mr-6">
                    <img src="{{ $parent->profile_photo ? asset('storage/' . $parent->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                        class="h-24 w-24 rounded-full object-cover border-2 border-indigo-400" alt="Profile Photo">
                    <input type="file" name="profile_photo"
                        class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                    @error('profile_photo')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <div class="mb-2">
                        <label class="block text-gray-700 text-sm font-bold mb-1">Name</label>
                        <div class="border rounded px-3 py-2 w-64 bg-gray-100">{{ $user->name }}</div>
                    </div>
                    <div class="mb-2">
                        <label class="block text-gray-700 text-sm font-bold mb-1">Email</label>
                        <div class="border rounded px-3 py-2 w-64 bg-gray-100">{{ $user->email }}</div>
                    </div>
                </div>
            </div>

            {{-- Editable --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ $parent->phone }}"
                        class="border rounded px-3 py-2 w-full" />
                    @error('phone') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">City</label>
                    <input type="text" name="city" value="{{ $parent->city }}"
                        class="border rounded px-3 py-2 w-full" />
                    @error('city') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">State</label>
                    <input type="text" name="state" value="{{ $parent->state }}"
                        class="border rounded px-3 py-2 w-full" />
                    @error('state') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Read-only display --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Date of Birth</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">
                        {{ $parent->dob ? \Carbon\Carbon::parse($parent->dob)->format('d M Y') : 'N/A' }}
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Gender</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">
                        {{ ucfirst($parent->gender) }}
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-1">Permanent Address</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">{{ $parent->permanent_address }}</div>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-1">Current Address</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">{{ $parent->current_address }}</div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">ZIP Code</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">{{ $parent->zip }}</div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Profession</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">{{ $parent->profession }}</div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Spouse Name</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">{{ $parent->spouse_name }}</div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Spouse Email</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">{{ $parent->spouse_email }}</div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Spouse Phone</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">{{ $parent->spouse_phone }}</div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Spouse Profession</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">{{ $parent->spouse_profession }}</div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Monthly Income</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">{{ $parent->monthly_income }}</div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Children</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">{{ $parent->number_of_children }}</div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Children Needing Care</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">{{ $parent->number_needing_care }}</div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Preferred Drop-off Time</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">{{ $parent->preferred_drop_off_time }}</div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Preferred Type of Caregiver</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">{{ $parent->preferred_type_of_caregiver }}</div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Preferred Radius</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">{{ $parent->preferred_radius }}</div>
                </div>

                {{-- Boolean Fields --}}
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Needs Special Needs Support</label>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $parent->needs_special_needs_support ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $parent->needs_special_needs_support ? 'Yes' : 'No' }}
                    </span>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-1">Reason for Service</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">
                        {{ $parent->reason_for_service }}
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Emergency Contact Name</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">{{ $parent->emergency_contact_name }}</div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Emergency Contact Phone</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">{{ $parent->emergency_contact_phone }}</div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-orange-400 hover:bg-orange-500 text-white font-semibold px-6 py-2 rounded-lg">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-parent.layouts.parent-layout>
