<x-playpal.layouts.playpal>
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow mt-8">
        <h2 class="text-2xl font-bold mb-6">My Profile</h2>

        @if (session('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('playpal.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Profile Image & Basic Info --}}
            <div class="flex items-center mb-6 justify-center">
                <div class="mr-6 text-center">
                    <img src="{{ $playpal && $playpal->profile_photo ? asset('storage/' . $playpal->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}"
                        class="h-24 w-24 rounded-full object-cover border-2 border-blue-400" alt="Profile Photo">
                    <input type="file" name="profile_photo"
                        class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
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

            {{-- Editable Fields --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ $playpal->phone }}"
                        class="border rounded px-3 py-2 w-full" />
                    @error('phone') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">City</label>
                    <input type="text" name="city" value="{{ $playpal->city }}"
                        class="border rounded px-3 py-2 w-full" />
                    @error('city') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">State</label>
                    <input type="text" name="state" value="{{ $playpal->state }}"
                        class="border rounded px-3 py-2 w-full" />
                    @error('state') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Read-Only Display --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Date of Birth</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">
                        {{ $playpal->dob ? $playpal->dob->format('d M Y') : 'N/A' }}
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Gender</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">
                        {{ ucfirst($playpal->gender) }}
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Service Radius</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">
                        {{ $playpal->service_radius }}
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Age Limit</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">
                        {{ $playpal->child_age_limit }}
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">ZIP Code</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">
                        {{ $playpal->zip }}
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Category</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">
                        {{ ucfirst($playpal->category) }}
                    </div>
                </div>

                @if ($playpal->permanent_address)
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-1">Permanent Address</label>
                        <div class="border rounded px-3 py-2 w-full bg-gray-100">
                            {{ $playpal->permanent_address }}
                        </div>
                    </div>
                @endif

                @if ($playpal->current_address)
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-1">Current Address</label>
                        <div class="border rounded px-3 py-2 w-full bg-gray-100">
                            {{ $playpal->current_address }}
                        </div>
                    </div>
                @endif

                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-1">Availability</label>
                    <div class="border rounded px-3 py-2 w-full bg-gray-100">
                        {{ is_array($playpal->availability) ? implode(', ', $playpal->availability) : $playpal->availability }}
                    </div>
                </div>

                {{-- Boolean badges --}}
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Willing to Take Insurance</label>
                    <span
                        class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $playpal->willing_to_take_insurance ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $playpal->willing_to_take_insurance ? 'Yes' : 'No' }}
                    </span>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Background Check Consent</label>
                    <span
                        class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $playpal->background_check_consent ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $playpal->background_check_consent ? 'Yes' : 'No' }}
                    </span>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Terms Accepted</label>
                    <span
                        class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $playpal->terms_accepted ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $playpal->terms_accepted ? 'Yes' : 'No' }}
                    </span>
                </div>
            </div>

            {{-- Documents --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                @php
                    $documents = [
                        'ID Proof' => $playpal->id_proof_path,
                        'Selfie' => $playpal->selfie_path,
                        'Marriage Certificate' => $playpal->marriage_certificate_path,
                        'Child Birth Certificate' => $playpal->child_birth_certificate_path,
                        'Birth Certificate' => $playpal->birth_certificate_path,
                        'Professional Certificate' => $playpal->certificate_path,
                    ];
                @endphp

                @foreach ($documents as $label => $path)
                    @if ($path)
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-1">{{ $label }}</label>
                            <a href="{{ asset('storage/' . $path) }}" target="_blank"
                                class="text-blue-600 underline hover:text-blue-800">
                                View
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-[#00bbae] hover:bg-orange-400 text-white font-semibold px-6 py-2 rounded-lg">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-playpal.layouts.playpal>