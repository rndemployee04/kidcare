<x-parent.layouts.parent-layout>
    <div class="max-w-3xl mx-auto bg-white dark:bg-neutral-800 rounded-xl shadow p-6">
        <h2 class="text-2xl font-bold mb-6">Add New Child</h2>

        <form action="{{ route('parent.children.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Full Name -->
                <div>
                    <label for="full_name" class="block font-medium mb-1">Full Name</label>
                    <input type="text" name="full_name" id="full_name" class="w-full border rounded px-3 py-2" required>
                </div>

                <!-- Date of Birth -->
                <div>
                    <label for="dob" class="block font-medium mb-1">Date of Birth</label>
                    <input type="date" name="dob" id="dob" class="w-full border rounded px-3 py-2" required>
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender" class="block font-medium mb-1">Gender</label>
                    <select name="gender" id="gender" class="w-full border rounded px-3 py-2" required>
                        <option value="">Select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <!-- Photo -->
                <div>
                    <label for="photo" class="block font-medium mb-1">Photo</label>
                    <input type="file" name="photo" id="photo" class="w-full border rounded px-3 py-2">
                </div>

                <!-- Birth Certificate -->
                <div>
                    <label for="birth_certificate_path" class="block font-medium mb-1">Birth Certificate</label>
                    <input type="file" name="birth_certificate_path" id="birth_certificate_path" class="w-full border rounded px-3 py-2">
                </div>

                <!-- ID Proof -->
                <div>
                    <label for="id_proof_path" class="block font-medium mb-1">ID Proof</label>
                    <input type="file" name="id_proof_path" id="id_proof_path" class="w-full border rounded px-3 py-2">
                </div>

                <!-- Has Insurance -->
                <div>
                    <label for="has_insurance" class="block font-medium mb-1">Has Insurance?</label>
                    <select name="has_insurance" id="has_insurance" class="w-full border rounded px-3 py-2">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>

                <!-- Insurance Company -->
                <div>
                    <label for="insurance_company" class="block font-medium mb-1">Insurance Company</label>
                    <input type="text" name="insurance_company" id="insurance_company" class="w-full border rounded px-3 py-2">
                </div>

                <!-- Insurance Terms -->
                <div class="md:col-span-2">
                    <label for="insurance_terms" class="block font-medium mb-1">Insurance Terms</label>
                    <textarea name="insurance_terms" id="insurance_terms" rows="2" class="w-full border rounded px-3 py-2"></textarea>
                </div>

                <!-- Diseases -->
                <div class="md:col-span-2">
                    <label for="diseases" class="block font-medium mb-1">Diseases (comma-separated)</label>
                    <input type="text" name="diseases" id="diseases" class="w-full border rounded px-3 py-2">
                </div>

                <!-- Disabilities -->
                <div class="md:col-span-2">
                    <label for="disabilities" class="block font-medium mb-1">Disabilities (comma-separated)</label>
                    <input type="text" name="disabilities" id="disabilities" class="w-full border rounded px-3 py-2">
                </div>

                <!-- Allergies -->
                <div class="md:col-span-2">
                    <label for="allergies" class="block font-medium mb-1">Allergies (comma-separated)</label>
                    <input type="text" name="allergies" id="allergies" class="w-full border rounded px-3 py-2">
                </div>

                <!-- Hobbies -->
                <div class="md:col-span-2">
                    <label for="hobbies" class="block font-medium mb-1">Hobbies</label>
                    <textarea name="hobbies" id="hobbies" rows="2" class="w-full border rounded px-3 py-2"></textarea>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Save Child
                </button>
            </div>
        </form>
    </div>
</x-parent.layouts.parent-layout>
