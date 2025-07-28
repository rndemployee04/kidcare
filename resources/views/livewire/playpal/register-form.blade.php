<div class="max-w-4xl mx-auto px-6 py-10 text-slate-900 dark:text-slate-100 bg-white shadow-xl rounded overflow-hidden">
    <div class="top-hed flex items-center mb-5">
        <x-auth-header :title="__('PlayPal Profile')" :description="__('Fill in your details below')" />
        <div class="flex justify-end mb-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="px-4 py-2 bg-orange-400 hover:bg-orange-500 text-white rounded-md transition font-semibold cursor-pointer">
                    Logout
                </button>
            </form>
        </div>
    </div>
    @if (session('message'))
        <div data-saved-message
            class="mb-4 p-4 bg-green-50 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-900 dark:text-green-100 rounded shadow flex items-center space-x-3 animate-fade-in">
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

    <form wire:submit.prevent="submit" class="space-y-8" enctype="multipart/form-data">
        {{-- Personal Info --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="phone" class="block mb-1 text-sm font-medium">Phone <span class="text-red-500">*</span></label>
                <input type="text" wire:model.defer="phone" id="phone" maxlength="13" pattern="[0-9]*"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition">
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Enter your mobile number for contact and verification.</p>
                @error('phone')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="dob" class="block mb-1 text-sm font-medium">Date of Birth <span class="text-red-500">*</span></label>
                <input type="date" wire:model.defer="dob" id="dob"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition">
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Your date of birth helps us verify your eligibility.</p>
                @error('dob')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="gender" class="block mb-1 text-sm font-medium">Gender <span class="text-red-500">*</span></label>
                <select wire:model.defer="gender" id="gender"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="others">Others</option>
                </select>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Select your gender for demographic purposes.</p>
                @error('gender')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="profile_photo" class="block mb-1 text-sm font-medium">Profile Photo <span class="text-red-500">*</span></label>
                <input type="file" wire:model="profile_photo" id="profile_photo" accept="image/*"
                    class="w-full file:bg-orange-400 file:text-white file:px-4 file:py-2 file:rounded-md file:border-0 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md">
                @if($profile_photo && is_string($profile_photo))
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Current file: {{ basename($profile_photo) }}</p>
                @endif
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Upload a recent photo for your profile. Max size: 2MB. JPG/PNG only.</p>
                @error('profile_photo')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Category --}}
        <div>
            <label for="category" class="block mb-1 text-sm font-medium">PlayPal Category <span class="text-red-500">*</span></label>
            <select wire:model.live="category" id="category"
                class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <option value="">Select Category</option>
                <option value="newlywed">Newlywed</option>
                <option value="professional">Professional</option>
                <option value="parent">Parent</option>
                <option value="senior">Senior</option>
            </select>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Select your PlayPal category.</p>
            @error('category')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Category-dependent documents --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if ($category === 'newlywed' || $category === 'parent')
                <div>
                    <label for="marriage_certificate_path" class="block mb-1 text-sm font-medium">Marriage Certificate (PDF/JPG)</label>
                    <input type="file" wire:model="marriage_certificate_path" id="marriage_certificate_path"
                        class="w-full file:bg-orange-400 file:text-white file:px-4 file:py-2 file:rounded-md file:border-0 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md">
                    @if($marriage_certificate_path && is_string($marriage_certificate_path))
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Current file: {{ basename($marriage_certificate_path) }}</p>
                    @endif
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Upload your marriage certificate for verification. Max size: 2MB. JPG/PDF</p>
                    @error('marriage_certificate_path')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            @endif
            @if ($category === 'professional')
                <div>
                    <label for="certificate_path" class="block mb-1 text-sm font-medium">Professional Certificate (PDF/JPG)</label>
                    <input type="file" wire:model="certificate_path" id="certificate_path"
                        class="w-full file:bg-orange-600 file:text-white file:px-4 file:py-2 file:rounded-md file:border-0 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md">
                    @if($certificate_path && is_string($certificate_path))
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Current file: {{ basename($certificate_path) }}</p>
                    @endif
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Upload your professional certification. Max size: 2MB. JPG/PDF</p>
                    @error('certificate_path')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            @endif
            @if ($category === 'parent')
                <div>
                    <label for="child_birth_certificate_path" class="block mb-1 text-sm font-medium">Child's Birth Certificate (PDF/JPG)</label>
                    <input type="file" wire:model="child_birth_certificate_path" id="child_birth_certificate_path"
                        class="w-full file:bg-orange-600 file:text-white file:px-4 file:py-2 file:rounded-md file:border-0 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md">
                    @if($child_birth_certificate_path && is_string($child_birth_certificate_path))
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Current file: {{ basename($child_birth_certificate_path) }}</p>
                    @endif
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Upload your child's birth certificate. Max size: 2MB. JPG/PDF</p>
                    @error('child_birth_certificate_path')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            @endif
            @if ($category === 'senior')
                <div>
                    <label for="birth_certificate_path" class="block mb-1 text-sm font-medium">Birth Certificate (PDF/JPG)</label>
                    <input type="file" wire:model="birth_certificate_path" id="birth_certificate_path"
                        class="w-full file:bg-orange-600 file:text-white file:px-4 file:py-2 file:rounded-md file:border-0 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md">
                    @if($birth_certificate_path && is_string($birth_certificate_path))
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Current file: {{ basename($birth_certificate_path) }}</p>
                    @endif
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Upload your birth certificate for age verification. Max size: 2MB. JPG/PDF</p>
                    @error('birth_certificate_path')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            @endif
        </div>

        {{-- Identity Verification --}}
        <div>
            <label for="id_proof_path" class="block mb-1 text-sm font-medium">ID Proof <span class="text-red-500">*</span></label>
            <input type="file" wire:model="id_proof_path" id="id_proof_path"
                class="w-full file:bg-orange-400 file:text-white file:px-4 file:py-2 file:rounded-md file:border-0 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md">
            @if($id_proof_path && is_string($id_proof_path))
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Current file: {{ basename($id_proof_path) }}</p>
            @endif
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Government issued ID (Driving License, Passport, etc.) Max size: 2MB. JPG/PDF</p>
            @error('id_proof_path')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            <div class="!mt-[1.5rem]">
                <label for="selfie_path" class="block mb-1 text-sm font-medium">Selfie with ID <span class="text-red-500">*</span></label>
                <div class="flex flex-col gap-2">
                    <div class="flex gap-2">
                        <input type="file" wire:model="selfie_path" id="selfie_path"
                            class="w-full file:bg-orange-400 file:text-white file:px-4 file:py-2 file:rounded-md file:border-0 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md">
                        <button type="button" onclick="openCamera()"
                            class="px-4 flex items-center justify-center py-2 bg-orange-400 text-white text-center rounded-md hover:bg-orange-500 transition-colors focus:outline-none focus:ring-2 focus:ring-orange-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                            </svg>
                        </button>
                    </div>
                    @if($selfie_path && is_string($selfie_path))
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Current file: {{ basename($selfie_path) }}</p>
                    @endif
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">A selfie holding your ID for verification. Max size: 2MB. JPG</p>
                    @error('selfie_path')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="col-span-2">
                <label class="inline-flex items-center mt-3">
                    <input type="checkbox" wire:model.defer="background_check_consent"
                        class="rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500">
                    <span class="ml-2">I consent to a background check <span class="text-red-500">*</span></span>
                </label>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Required for the safety of children in our community.</p>
                @error('background_check_consent')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Address Information --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label for="permanent_address" class="block mb-1 text-sm font-medium">Permanent Address <span class="text-red-500">*</span></label>
                <input type="text" wire:model.defer="permanent_address" id="permanent_address"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Your official permanent address.</p>
                @error('permanent_address')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="current_address" class="block mb-1 text-sm font-medium">Current Address <span class="text-red-500">*</span></label>
                <input type="text" wire:model.defer="current_address" id="current_address"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Where you currently reside.</p>
                @error('current_address')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="city" class="block mb-1 text-sm font-medium">City <span class="text-red-500">*</span></label>
                <input type="text" wire:model.defer="city" id="city"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                @error('city')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="state" class="block mb-1 text-sm font-medium">State <span class="text-red-500">*</span></label>
                <input type="text" wire:model.defer="state" id="state"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                @error('state')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="zip" class="block mb-1 text-sm font-medium">ZIP Code <span class="text-red-500">*</span></label>
                <input type="text" wire:model.defer="zip" id="zip"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                @error('zip')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Preferences --}}
        <h2 class="text-xl font-semibold mb-6 border-b border-slate-200 dark:border-slate-700 pb-2">Preferences</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="service_radius" class="block mb-1 text-sm font-medium">Service Radius <span class="text-red-500">*</span></label>
                <select wire:model.defer="service_radius" id="service_radius"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="">Select Radius</option>
                    <option value="2-3">2-3 km</option>
                    <option value="3-4">3-4 km</option>
                    <option value="4-5">4-5 km</option>
                </select>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">How far you're willing to travel for caregiving.</p>
                @error('service_radius')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="child_age_limit" class="block mb-1 text-sm font-medium">Child Age Limit <span class="text-red-500">*</span></label>
                <select wire:model.defer="child_age_limit" id="child_age_limit"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="">Select Age Limit</option>
                    <option value="2-3">2-3 yrs</option>
                    <option value="3-5">3-5 yrs</option>
                    <option value="5-8">5-8 yrs</option>
                    <option value="8-10">8-10 yrs</option>
                    <option value="all">All Ages</option>
                </select>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Age range of children you're comfortable caring for.</p>
                @error('child_age_limit')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Availability --}}
        <div>
            <label class="block mb-1 text-sm font-medium">Availability <span class="text-red-500">*</span></label>
            <div class="flex flex-wrap gap-4">
                @foreach ([['morning', 'Morning'], ['afternoon', 'Afternoon'], ['evening', 'Evening'], ['full-day', 'Full Day']] as [$val, $label])
                    <label class="inline-flex items-center">
                        <input type="checkbox" wire:model.defer="availability" value="{{ $val }}"
                            class="rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Select when you're available for caregiving.</p>
            @error('availability')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Willing to Take Insurance --}}
        <div>
            <label class="inline-flex items-center mt-3">
                <input type="checkbox" wire:model.defer="willing_to_take_insurance"
                    class="rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500">
                <span class="ml-2">Willing to take insurance?</span>
            </label>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Check if you want our insurance services.</p>
        </div>

        {{-- Terms Accepted --}}
        <div>
            <label class="inline-flex items-center mt-3">
                <input type="checkbox" wire:model.defer="terms_accepted"
                    class="rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500">
                <span class="ml-2">I accept the <a href="#" class="text-blue-600 dark:text-blue-400 underline">terms and conditions</a> <span class="text-red-500">*</span></span>
            </label>
            @error('terms_accepted')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="flex gap-4 mt-8">
            <button type="button" wire:click="saveDraft"
                class="px-6 py-2 border border-slate-300 dark:border-slate-600 rounded-md bg-white dark:bg-slate-800 text-slate-900 dark:text-white transition hover:bg-green-50 hover:border-green-500 hover:text-green-800 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-green-400 cursor-pointer">
                <svg class="inline w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                Save & Resume Later
            </button>
            <button type="submit"
                class="px-6 py-2 bg-orange-400 hover:bg-orange-500 text-white rounded-md transition font-semibold cursor-pointer">
                Submit Registration
            </button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Camera functionality (copied from CareBuddy)
    let cameraModal = null;
    let cameraStream = null;
    let cameraCanvas = null;
    function openCamera() {
        cameraModal = document.getElementById('cameraModal');
        cameraCanvas = document.getElementById('cameraCanvas');
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function (stream) {
                cameraStream = stream;
                document.getElementById('cameraVideo').srcObject = stream;
                cameraModal.classList.remove('hidden');
            });
    }
    function closeCamera() {
        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
            cameraStream = null;
        }
        cameraModal.classList.add('hidden');
    }
</script>
