<div class="max-w-4xl mx-auto px-6 py-10 text-slate-900 dark:text-slate-100">
    <x-auth-header :title="__('CareBuddy Profile')" :description="__('Fill in your details below')" />

    <div class="flex justify-end mb-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition font-semibold cursor-pointer">
                Logout
            </button>
        </form>
    </div>

    @if (session('message'))
        <div data-saved-message
            class="mb-4 p-4 bg-green-50 border border-green-400 text-green-900 rounded shadow flex items-center space-x-3 animate-fade-in">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            <div>
                <strong>Your progress has been saved!</strong><br>
                <span>You can safely close this page and resume registration later.</span>
            </div>
        </div>
    @endif

    {{-- Info Board: Carebuddy Category --}}
    <div class="mb-6">
        <div
            class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded shadow flex items-start gap-3">
            <svg class="w-6 h-6 mt-1 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13 16h-1v-4h-1m1-4h.01M12 20.5a8.38 8.38 0 100-16.76 8.38 8.38 0 000 16.76z"></path>
            </svg>
            <div>
                <strong>Confused about CareBuddy Category?</strong><br>
                <span>
                    <b>Newlywed:</b> Young couples, energetic and nurturing.<br>
                    <b>Professional:</b> Certified nannies, therapists.<br>
                    <b>Parent:</b> Experienced parents.<br>
                    <b>Senior:</b> Elderly with wisdom and patience.<br>
                </span>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="submit" class="space-y-8">
        {{-- Personal Info --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="phone" class="block mb-1 text-sm font-medium">Phone <span
                        class="text-red-500">*</span></label>
                <input type="text" wire:model.defer="phone" id="phone"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition">
                <p class="text-xs text-slate-500 mt-1">
                    Enter your mobile number for contact and verification.
                </p>
                @error('phone')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="dob" class="block mb-1 text-sm font-medium">Date of Birth <span
                        class="text-red-500">*</span></label>
                <input type="date" wire:model.defer="dob" id="dob"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition">
                <p class="text-xs text-slate-500 mt-1">
                    Your date of birth helps us verify your eligibility.
                </p>
                @error('dob')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="gender" class="block mb-1 text-sm font-medium">Gender <span
                        class="text-red-500">*</span></label>
                <select wire:model.defer="gender" id="gender"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="others">Others</option>
                </select>
                <p class="text-xs text-slate-500 mt-1">
                    Select your gender for demographic purposes.
                </p>
                @error('gender')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="profile_photo" class="block mb-1 text-sm font-medium">Profile Photo</label>
                <input type="file" wire:model="profile_photo" id="profile_photo"
                    class="w-full file:bg-indigo-600 file:text-white file:px-4 file:py-2 file:rounded-md bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md">
                <p class="text-xs text-slate-500 mt-1">
                    Upload a recent photo for your profile. Max size: 2MB. JPG/PNG only.
                </p>
                @error('profile_photo')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Category --}}
        <div>
            <label for="category" class="block mb-1 text-sm font-medium">Category <span
                    class="text-red-500">*</span></label>
            <select wire:model.defer="category" id="category"
                class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <option value="">Select Category</option>
                <option value="newlywed">Newlywed</option>
                <option value="professional">Professional</option>
                <option value="parent">Parent</option>
                <option value="senior">Senior</option>
            </select>
            @error('category')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>

        {{-- Category-dependent documents --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if ($category === 'newlywed' || $category === 'parent')
                <div>
                    <label for="marriage_certificate_path" class="block mb-1 text-sm font-medium">Marriage Certificate
                        (PDF/JPG)</label>
                    <input type="file" wire:model="marriage_certificate_path" id="marriage_certificate_path"
                        class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer focus:outline-none focus:border-transparent">
                    @error('marriage_certificate_path')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
            @endif
            @if ($category === 'professional')
                <div>
                    <label for="certificate_path" class="block mb-1 text-sm font-medium">Professional Certificate
                        (PDF/JPG)</label>
                    <input type="file" wire:model="certificate_path" id="certificate_path"
                        class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer focus:outline-none focus:border-transparent">
                    @error('certificate_path')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
            @endif
            @if ($category === 'parent')
                <div>
                    <label for="child_birth_certificate_path" class="block mb-1 text-sm font-medium">Child's Birth
                        Certificate (PDF/JPG)</label>
                    <input type="file" wire:model="child_birth_certificate_path" id="child_birth_certificate_path"
                        class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer focus:outline-none focus:border-transparent">
                    @error('child_birth_certificate_path')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
            @endif
            @if ($category === 'senior')
                <div>
                    <label for="birth_certificate_path" class="block mb-1 text-sm font-medium">Birth Certificate
                        (PDF/JPG)</label>
                    <input type="file" wire:model="birth_certificate_path" id="birth_certificate_path"
                        class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer focus:outline-none focus:border-transparent">
                    @error('birth_certificate_path')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
            @endif
        </div>

        {{-- Identity Verification --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="id_proof_path" class="block mb-1 text-sm font-medium">ID Proof <span
                        class="text-red-500">*</span></label>
                <input type="file" wire:model="id_proof_path" id="id_proof_path"
                    class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer focus:outline-none focus:border-transparent">
                @error('id_proof_path')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="selfie_path" class="block mb-1 text-sm font-medium">Selfie <span
                        class="text-red-500">*</span></label>
                <input type="file" wire:model="selfie_path" id="selfie_path" class="form-input w-full">
                @error('selfie_path')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-span-2">
                <label class="inline-flex items-center mt-3">
                    <input type="checkbox" wire:model.defer="background_check_consent" class="form-checkbox">
                    <span class="ml-2">I consent to a background check <span class="text-red-500">*</span></span>
                </label>
                @error('background_check_consent')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div>
            <label for="dob" class="block mb-1 text-sm font-medium">Date of Birth <span
                    class="text-red-500">*</span></label>
            <input type="date" wire:model.defer="dob" id="dob" class="form-input w-full">
            @error('dob')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="gender" class="block mb-1 text-sm font-medium">Gender <span
                    class="text-red-500">*</span></label>
            <select wire:model.defer="gender" id="gender" class="form-select w-full">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="others">Others</option>
            </select>
            @error('gender')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="profile_photo" class="block mb-1 text-sm font-medium">Profile Photo</label>
            <input type="file" wire:model="profile_photo" id="profile_photo" class="form-input w-full">
            @error('profile_photo')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>

        {{-- Address Info --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="permanent_address" class="block mb-1 text-sm font-medium">Permanent Address <span
                        class="text-red-500">*</span></label>
                <input type="text" wire:model.defer="permanent_address" id="permanent_address"
                    class="form-input w-full">
                @error('permanent_address')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="current_address" class="block mb-1 text-sm font-medium">Current Address <span
                        class="text-red-500">*</span></label>
                <input type="text" wire:model.defer="current_address" id="current_address"
                    class="form-input w-full">
                @error('current_address')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="city" class="block mb-1 text-sm font-medium">City <span
                        class="text-red-500">*</span></label>
                <input type="text" wire:model.defer="city" id="city" class="form-input w-full">
                @error('city')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="state" class="block mb-1 text-sm font-medium">State <span
                        class="text-red-500">*</span></label>
                <input type="text" wire:model.defer="state" id="state" class="form-input w-full">
                @error('state')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="zip" class="block mb-1 text-sm font-medium">ZIP Code <span
                        class="text-red-500">*</span></label>
                <input type="text" wire:model.defer="zip" id="zip" class="form-input w-full">
                @error('zip')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Preferences --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="service_radius" class="block mb-1 text-sm font-medium">Service Radius <span
                        class="text-red-500">*</span></label>
                <select wire:model.defer="service_radius" id="service_radius" class="form-select w-full">
                    <option value="">Select Radius</option>
                    <option value="2-3">2-3 km</option>
                    <option value="3-4">3-4 km</option>
                    <option value="4-5">4-5 km</option>
                </select>
                @error('service_radius')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="child_age_limit" class="block mb-1 text-sm font-medium">Child Age Limit <span
                        class="text-red-500">*</span></label>
                <select wire:model.defer="child_age_limit" id="child_age_limit" class="form-select w-full">
                    <option value="">Select Age Limit</option>
                    <option value="2-3">2-3 yrs</option>
                    <option value="3-5">3-5 yrs</option>
                    <option value="5-8">5-8 yrs</option>
                    <option value="8-10">8-10 yrs</option>
                    <option value="all">All Ages</option>
                </select>
                @error('child_age_limit')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Availability --}}
        <div>
            <label for="availability" class="block mb-1 text-sm font-medium">Availability <span
                    class="text-red-500">*</span></label>
            <div class="flex flex-wrap gap-3">
                @foreach ([['morning', 'Morning'], ['afternoon', 'Afternoon'], ['evening', 'Evening'], ['full-day', 'Full Day']] as [$val, $label])
                    <label class="inline-flex items-center">
                        <input type="checkbox" wire:model.defer="availability" value="{{ $val }}"
                            class="form-checkbox">
                        <span class="ml-2">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
            @error('availability')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>

        {{-- Willing to Take Insurance --}}
        <div>
            <label class="inline-flex items-center mt-3">
                <input type="checkbox" wire:model.defer="willing_to_take_insurance" class="form-checkbox">
                <span class="ml-2">Willing to take insurance payments</span>
            </label>
        </div>

        {{-- Terms Accepted --}}
        <div>
            <label class="inline-flex items-center mt-3">
                <input type="checkbox" wire:model.defer="terms_accepted" class="form-checkbox">
                <span class="ml-2">I accept the <a href="#" class="text-blue-600 underline">terms and
                        conditions</a> <span class="text-red-500">*</span></span>
            </label>
            @error('terms_accepted')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>

        {{-- Save & Submit Buttons --}}
        <div class="flex gap-4 mt-8">
            <button type="button" wire:click="saveDraft"
                class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded font-semibold shadow transition">
                Save & Resume Later
            </button>
            <button type="submit"
                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded font-semibold shadow transition">
                Submit Registration
            </button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.addEventListener('draft-saved', function() {
        Swal.fire({
            icon: 'success',
            title: 'Draft Saved',
            text: 'Your progress has been saved! You can resume later.',
            timer: 2500,
            showConfirmButton: false
        });
    });
</script>
