<x-parent.layouts.parent-layout>
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow mt-8">
        <h2 class="text-2xl font-bold mb-6">My Profile</h2>
        @if (session('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif
        <form method="POST" action="{{ route('parent.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex items-center mb-6">
                <div class="mr-6">
                    <img src="{{ $parent && $parent->profile_photo ? asset('storage/' . $parent->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}"
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
                        <input type="text" value="{{ $user->name }}"
                            class="border rounded px-3 py-2 w-64 bg-gray-100" readonly>
                    </div>
                    <div class="mb-2">
                        <label class="block text-gray-700 text-sm font-bold mb-1">Email</label>
                        <input type="email" value="{{ $user->email }}"
                            class="border rounded px-3 py-2 w-64 bg-gray-100" readonly>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ $parent->phone }}"
                        class="border rounded px-3 py-2 w-full" />
                    @error('phone')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">City</label>
                    <input type="text" name="city" value="{{ $parent->city }}"
                        class="border rounded px-3 py-2 w-full" />
                    @error('city')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">State</label>
                    <input type="text" name="state" value="{{ $parent->state }}"
                        class="border rounded px-3 py-2 w-full" />
                    @error('state')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Date of Birth</label>
                    <input type="text" value="{{ $parent->dob ? \Carbon\Carbon::parse($parent->dob)->format('d M Y') : 'N/A' }}"
                        class="border rounded px-3 py-2 w-full bg-gray-100" readonly />
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Gender</label>
                    <input type="text" value="{{ ucfirst($parent->gender) }}"
                        class="border rounded px-3 py-2 w-full bg-gray-100" readonly />
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-1">Address</label>
                    <input type="text" value="{{ $parent->address }}"
                        class="border rounded px-3 py-2 w-full bg-gray-100" readonly />
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-orange-400 hover:bg-orange-500 text-white font-semibold px-6 py-2 rounded-lg">Save
                    Changes</button>
            </div>
        </form>
    </div>
</x-parent.layouts.parent-layout>
