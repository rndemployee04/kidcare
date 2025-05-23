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

    {{-- Info Board: Carebuddy Category --}}
    <div class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- CareBuddy Category Grid -->
            <div
                class="bg-yellow-100 dark:bg-yellow-900 border-l-4 border-yellow-500 dark:border-yellow-600 text-yellow-800 dark:text-yellow-100 p-4 rounded shadow flex items-start gap-3">
                <svg class="w-6 h-6 mt-1 text-yellow-500 dark:text-yellow-300" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
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

            <!-- Availability Time Slots Grid -->
            <div
                class="bg-yellow-100 dark:bg-yellow-900 border-l-4 border-yellow-500 dark:border-yellow-600 text-yellow-800 dark:text-yellow-100 p-4 rounded shadow flex items-start gap-3">
                <svg class="w-6 h-6 mt-1 text-yellow-500 dark:text-yellow-300" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m1-4h.01M12 20.5a8.38 8.38 0 100-16.76 8.38 8.38 0 000 16.76z"></path>
                </svg>
                <div>
                    <strong>Confused about Availability Time Slots?</strong><br>
                    <span>
                        <b>Morning:</b> 9 AM – 12 PM<br>
                        <b>Afternoon:</b> 12 PM – 3 PM<br>
                        <b>Evening:</b> 3 PM – 6 PM<br>
                        <b>Full Day:</b> 9 AM – 6 PM<br>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="submit" class="space-y-8" enctype="multipart/form-data">
        <h2 class="text-xl font-semibold mb-6 border-b border-slate-200 dark:border-slate-700 pb-2">Personal Information
        </h2>

        {{-- Personal Info --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="phone" class="block mb-1 text-sm font-medium">Phone <span
                        class="text-red-500">*</span></label>
                <input type="text" wire:model.defer="phone" id="phone"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition">
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Enter your mobile number for contact and
                    verification.</p>
                @error('phone')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="dob" class="block mb-1 text-sm font-medium">Date of Birth <span
                        class="text-red-500">*</span></label>
                <input type="date" wire:model.defer="dob" id="dob"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition">
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Your date of birth helps us verify your
                    eligibility.</p>
                @error('dob')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
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
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Select your gender for demographic purposes.
                </p>
                @error('gender')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="profile_photo" class="block mb-1 text-sm font-medium">Profile Photo</label>
                <input type="file" wire:model="profile_photo" id="profile_photo"
                    class="w-full file:bg-indigo-600 file:text-white file:px-4 file:py-2 file:rounded-md file:border-0 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md">
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Upload a recent photo for your profile. Max
                    size: 2MB. JPG/PNG only.</p>
                @error('profile_photo')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
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
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Select your CareBuddy category based on the
                information above.</p>
            @error('category')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Category-dependent documents --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if ($category === 'newlywed' || $category === 'parent')
                <div>
                    <label for="marriage_certificate_path" class="block mb-1 text-sm font-medium">Marriage Certificate
                        (PDF/JPG)</label>
                    <input type="file" wire:model="marriage_certificate_path" id="marriage_certificate_path"
                        class="w-full file:bg-indigo-600 file:text-white file:px-4 file:py-2 file:rounded-md file:border-0 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Upload your marriage certificate for
                        verification.</p>
                    @error('marriage_certificate_path')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            @if ($category === 'professional')
                <div>
                    <label for="certificate_path" class="block mb-1 text-sm font-medium">Professional Certificate
                        (PDF/JPG)</label>
                    <input type="file" wire:model="certificate_path" id="certificate_path"
                        class="w-full file:bg-indigo-600 file:text-white file:px-4 file:py-2 file:rounded-md file:border-0 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Upload your professional certification.</p>
                    @error('certificate_path')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            @if ($category === 'parent')
                <div>
                    <label for="child_birth_certificate_path" class="block mb-1 text-sm font-medium">Child's Birth
                        Certificate (PDF/JPG)</label>
                    <input type="file" wire:model="child_birth_certificate_path" id="child_birth_certificate_path"
                        class="w-full file:bg-indigo-600 file:text-white file:px-4 file:py-2 file:rounded-md file:border-0 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Upload your child's birth certificate.</p>
                    @error('child_birth_certificate_path')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            @if ($category === 'senior')
                <div>
                    <label for="birth_certificate_path" class="block mb-1 text-sm font-medium">Birth Certificate
                        (PDF/JPG)</label>
                    <input type="file" wire:model="birth_certificate_path" id="birth_certificate_path"
                        class="w-full file:bg-indigo-600 file:text-white file:px-4 file:py-2 file:rounded-md file:border-0 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Upload your birth certificate for age
                        verification.</p>
                    @error('birth_certificate_path')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endif
        </div>

        <h2 class="text-xl font-semibold mb-6 border-b border-slate-200 dark:border-slate-700 pb-2">Identity
            Verification</h2>

        <div>
            <label for="id_proof_path" class="block mb-1 text-sm font-medium">ID Proof <span
                    class="text-red-500">*</span></label>
            <input type="file" wire:model="id_proof_path" id="id_proof_path"
                class="w-full file:bg-indigo-600 file:text-white file:px-4 file:py-2 file:rounded-md file:border-0 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md">
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Government issued ID (Aadhaar, Passport,
                etc.)</p>
            @error('id_proof_path')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
            <div>
                <label for="selfie_path" class="block mb-1 text-sm font-medium">Selfie with ID <span
                        class="text-red-500">*</span></label>
                <input type="file" wire:model="selfie_path" id="selfie_path"
                    class="w-full file:bg-indigo-600 file:text-white file:px-4 file:py-2 file:rounded-md file:border-0 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md">
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">A selfie holding your ID for verification.
                </p>
                @error('selfie_path')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center my-3">
                <div class="flex-grow h-px bg-slate-300 dark:bg-slate-600"></div>
                <span class="mx-3 text-sm text-slate-500 dark:text-slate-400">or verify using DigiLocker</span>
                <div class="flex-grow h-px bg-slate-300 dark:bg-slate-600"></div>
            </div>
            <a href="#" onclick="return false;"
                class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white dark:bg-blue-500 dark:text-white rounded-md hover:bg-blue-700 dark:hover:bg-blue-600 text-base font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-blue-400 mb-2">
                <img src="https://img1.digitallocker.gov.in/digilocker-landing-page/assets/img/about-1.svg"
                    alt="DigiLocker" style="height:28px;width:auto;" class="mr-2">
                Verify with DigiLocker
            </a>

        </div>



        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="col-span-2">
                <label class="inline-flex items-center mt-3">
                    <input type="checkbox" wire:model.defer="background_check_consent"
                        class="rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500">
                    <span class="ml-2">I consent to a background check <span class="text-red-500">*</span></span>
                </label>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Required for the safety of children in our
                    community.</p>
                @error('background_check_consent')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <h2 class="text-xl font-semibold mb-6 border-b border-slate-200 dark:border-slate-700 pb-2">Address Information
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label for="permanent_address" class="block mb-1 text-sm font-medium">Permanent Address <span
                        class="text-red-500">*</span></label>
                <input type="text" wire:model.defer="permanent_address" id="permanent_address"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Your official permanent address.</p>
                @error('permanent_address')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="current_address" class="block mb-1 text-sm font-medium">Current Address <span
                        class="text-red-500">*</span></label>
                <input type="text" wire:model.defer="current_address" id="current_address"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Where you currently reside.</p>
                @error('current_address')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="city" class="block mb-1 text-sm font-medium">City <span
                        class="text-red-500">*</span></label>
                <input type="text" wire:model.defer="city" id="city"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                @error('city')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="state" class="block mb-1 text-sm font-medium">State <span
                        class="text-red-500">*</span></label>
                <input type="text" wire:model.defer="state" id="state"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                @error('state')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="zip" class="block mb-1 text-sm font-medium">ZIP Code <span
                        class="text-red-500">*</span></label>
                <input type="text" wire:model.defer="zip" id="zip"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                @error('zip')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center my-3">
            <div class="flex-grow h-px bg-slate-300 dark:bg-slate-600"></div>
            <span class="mx-3 text-sm text-slate-500 dark:text-slate-400">or select your location on the map</span>
            <div class="flex-grow h-px bg-slate-300 dark:bg-slate-600"></div>
        </div>

        {{-- Location Selection --}}
        <div class="mb-8">
            <label class="block mb-1 text-sm font-medium">Select Location on Map <span
                    class="text-red-500">*</span></label>
            <div
                class="w-full h-64 rounded-lg border-2 border-dashed border-indigo-400 overflow-hidden relative bg-slate-200 dark:bg-slate-700">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.019551955561!2d144.9630579153162!3d-37.8141079797517!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577c6b2e6b1b7e4!2sFederation%20Square!5e0!3m2!1sen!2sin!4v1620211234567!5m2!1sen!2sin"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                <span
                    class="absolute bottom-2 left-1/2 -translate-x-1/2 text-xs text-slate-500 dark:text-slate-400">(MVP:
                    Visual only, not functional)</span>
            </div>
        </div>

        <h2 class="text-xl font-semibold mb-6 border-b border-slate-200 dark:border-slate-700 pb-2">Preferences</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="service_radius" class="block mb-1 text-sm font-medium">Service Radius <span
                        class="text-red-500">*</span></label>
                <select wire:model.defer="service_radius" id="service_radius"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="">Select Radius</option>
                    <option value="2-3">2-3 km</option>
                    <option value="3-4">3-4 km</option>
                    <option value="4-5">4-5 km</option>
                </select>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">How far you're willing to travel for
                    caregiving.</p>
                @error('service_radius')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="child_age_limit" class="block mb-1 text-sm font-medium">Child Age Limit <span
                        class="text-red-500">*</span></label>
                <select wire:model.defer="child_age_limit" id="child_age_limit"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="">Select Age Limit</option>
                    <option value="2-3">2-3 yrs</option>
                    <option value="3-5">3-5 yrs</option>
                    <option value="5-8">5-8 yrs</option>
                    <option value="8-10">8-10 yrs</option>
                    <option value="all">All Ages</option>
                </select>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Age range of children you're comfortable
                    caring for.</p>
                @error('child_age_limit')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
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
            @error('availability')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Willing to Take Insurance --}}
        <div>
            <label class="inline-flex items-center mt-3">
                <input type="checkbox" wire:model.defer="willing_to_take_insurance"
                    class="rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500">
                <span class="ml-2">Willing to take insurance?</span>
            </label>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Check if you want our insurance
                services.</p>
        </div>

        {{-- Terms Accepted --}}
        <div>
            <label class="inline-flex items-center mt-3">
                <input type="checkbox" wire:model.defer="terms_accepted"
                    class="rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500">
                <span class="ml-2">I accept the <a href="#" class="text-blue-600 dark:text-blue-400 underline">terms and
                        conditions</a> <span class="text-red-500">*</span></span>
            </label>
            @error('terms_accepted')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Location Selection Placeholder --}}
        {{-- Save & Submit Buttons --}}
        <div class="flex gap-4 mt-8">
            <button type="button" wire:click="saveDraft"
                class="px-6 py-2 border border-slate-300 dark:border-slate-600 rounded-md bg-white dark:bg-slate-800 text-slate-900 dark:text-white transition hover:bg-green-50 hover:border-green-500 hover:text-green-800 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-green-400 cursor-pointer">
                <svg class="inline w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                Save & Resume Later
            </button>

            <button type="submit"
                class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition font-semibold cursor-pointer">
                Submit Registration
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.addEventListener('draft-saved', function () {
        Swal.fire({
            icon: 'success',
            title: 'Draft Saved',
            text: 'Your progress has been saved! You can resume later.',
            confirmButtonColor: '#16a34a'
        });
    });
</script>