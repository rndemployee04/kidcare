<div>
    <h2 class="text-2xl font-bold mb-4">Your Kids</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">{{ session('error') }}</div>
    @endif
    @if (!$limitReached)
        <!-- Create Form -->
        <form wire:submit.prevent="save" enctype="multipart/form-data"
            class="bg-white dark:bg-neutral-800 p-4 rounded shadow mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Full Name -->
                <div>
                    <label for="full_name" class="block text-sm font-medium mb-1">Full Name</label>
                    <input wire:model="full_name" id="full_name" type="text" class="w-full border rounded px-3 py-2"
                        required>
                </div>

                <!-- Date of Birth -->
                <div>
                    <label for="dob" class="block text-sm font-medium mb-1">Date of Birth</label>
                    <input wire:model="dob" id="dob" type="date" class="w-full border rounded px-3 py-2" required>
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-sm font-medium mb-1">Gender</label>
                    <select wire:model="gender" id="gender" class="w-full border rounded px-3 py-2">
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="others">Other</option>
                    </select>
                </div>

                <!-- Photo -->
                <div>
                    <label for="photo" class="block text-sm font-medium mb-1">Photo</label>
                    <input wire:model="photo" id="photo" type="file" class="w-full border rounded px-3 py-2">
                </div>

                <!-- Birth Certificate -->
                <div>
                    <label for="birth_certificate_path" class="block text-sm font-medium mb-1">Birth Certificate</label>
                    <input wire:model="birth_certificate_path" id="birth_certificate_path" type="file"
                        class="w-full border rounded px-3 py-2">
                </div>

                <!-- ID Proof -->
                <div>
                    <label for="id_proof_path" class="block text-sm font-medium mb-1">ID Proof</label>
                    <input wire:model="id_proof_path" id="id_proof_path" type="file"
                        class="w-full border rounded px-3 py-2">
                </div>

                <!-- Has Insurance -->
                <div>
                    <label for="has_insurance" class="block text-sm font-medium mb-1">Has Insurance?</label>
                    <select wire:model="has_insurance" id="has_insurance" class="w-full border rounded px-3 py-2">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>

                <!-- Insurance Company -->
                <div>
                    <label for="insurance_company" class="block text-sm font-medium mb-1">Insurance Company</label>
                    <input wire:model="insurance_company" id="insurance_company" type="text"
                        class="w-full border rounded px-3 py-2">
                </div>

                <!-- Insurance Terms -->
                <div class="md:col-span-2">
                    <label for="insurance_terms" class="block text-sm font-medium mb-1">Insurance Terms</label>
                    <textarea wire:model="insurance_terms" id="insurance_terms" rows="2"
                        class="w-full border rounded px-3 py-2"></textarea>
                </div>

                <!-- Diseases -->
                <div class="md:col-span-2">
                    <label for="diseases" class="block text-sm font-medium mb-1">Diseases (comma-separated)</label>
                    <input wire:model="diseases" id="diseases" type="text" class="w-full border rounded px-3 py-2">
                </div>

                <!-- Disabilities -->
                <div class="md:col-span-2">
                    <label for="disabilities" class="block text-sm font-medium mb-1">Disabilities (comma-separated)</label>
                    <input wire:model="disabilities" id="disabilities" type="text" class="w-full border rounded px-3 py-2">
                </div>

                <!-- Allergies -->
                <div class="md:col-span-2">
                    <label for="allergies" class="block text-sm font-medium mb-1">Allergies (comma-separated)</label>
                    <input wire:model="allergies" id="allergies" type="text" class="w-full border rounded px-3 py-2">
                </div>

                <!-- Hobbies -->
                <div class="md:col-span-2">
                    <label for="hobbies" class="block text-sm font-medium mb-1">Hobbies</label>
                    <textarea wire:model="hobbies" id="hobbies" rows="2" class="w-full border rounded px-3 py-2"></textarea>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Child</button>
            </div>
        </form>

    @endif
    <!-- Child List -->
    <table class="w-full border bg-white dark:bg-neutral-800 rounded-xl shadow text-left">
        <thead>
            <tr>
                <th class="py-2 px-4">Name</th>
                <th class="py-2 px-4">DOB</th>
                <th class="py-2 px-4">Gender</th>
                <th class="py-2 px-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($children as $child)
                <tr class="border-t">
                    <td class="py-2 px-4">{{ $child->full_name }}</td>
                    <td class="py-2 px-4">{{ $child->dob->format('d M Y') }}</td>
                    <td class="py-2 px-4 capitalize">{{ $child->gender }}</td>
                    <td class="py-2 px-4">
                        <button wire:click="edit({{ $child->id }})" class="text-blue-600 hover:underline mr-2">Edit</button>

                        <button wire:click="delete({{ $child->id }})" class="text-red-600 hover:underline">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="py-4 text-center text-gray-500">No children found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Modal Background -->
    @if ($editMode)
        <div class="fixed inset-0 bg-transparent backdrop-blur-xl bg-opacity-50 z-40 flex items-center justify-center">
            <!-- Modal Box -->
            <div class="bg-white dark:bg-neutral-800 rounded-lg shadow-lg p-6 w-full max-w-2xl z-50">
                <h3 class="text-lg font-semibold mb-4">Edit Child</h3>

                <form wire:submit.prevent="update" enctype="multipart/form-data"
                    class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Repeat form fields here just like in create form -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Full Name</label>
                        <input wire:model="full_name" type="text" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Date of Birth</label>
                        <input wire:model="dob" type="date" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Gender</label>
                        <select wire:model="gender" class="w-full border rounded px-3 py-2">
                            <option value="">Select</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- Optional File Inputs -->
                    <div>
                        <label class="block text-sm font-medium mb-1">New Photo (optional)</label>
                        <input wire:model="photo" type="file" class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-1">Diseases</label>
                        <input wire:model="diseases" type="text" class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-1">Allergies</label>
                        <input wire:model="allergies" type="text" class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-1">Hobbies</label>
                        <textarea wire:model="hobbies" class="w-full border rounded px-3 py-2"></textarea>
                    </div>

                    <div class="md:col-span-2 flex justify-end space-x-2 mt-4">
                        <button type="button" wire:click="$set('editMode', false)"
                            class="bg-gray-300 text-black px-4 py-2 rounded">Cancel</button>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>