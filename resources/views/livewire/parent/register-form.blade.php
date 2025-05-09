<div class="max-w-4xl mx-auto px-6 py-10 text-slate-900 dark:text-slate-100">
    <x-auth-header :title="__('Parent Profile')" :description="__('Fill in your details below')" />

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
    <form wire:submit.prevent="submit" class="space-y-8">

        {{-- Info Board: Caregiver Type --}}
        <div class="mb-6">
            <div
                class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded shadow flex items-start gap-3">
                <svg class="w-6 h-6 mt-1 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m1-4h.01M12 20.5a8.38 8.38 0 100-16.76 8.38 8.38 0 000 16.76z"></path>
                </svg>
                <div>
                    <strong>Confused about Caregiver Type?</strong><br>
                    <span>
                        <b>Newlywed:</b> Young couples, energetic and nurturing.<br>
                        <b>Professional:</b> Certified nannies, therapists.<br>
                        <b>Parent:</b> Other parents, great for socializing shy kids.<br>
                        <b>Senior:</b> Elderly with wisdom, patience, and care.<br>
                        <b>Any:</b> Open to all CareBuddy types.<br>
                    </span>
                </div>
            </div>
        </div>


        {{-- Personal Info --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ([['phone', 'Phone'], ['dob', 'Date of Birth']] as [$field, $label])
                <div>
                    <label for="{{ $field }}" class="block mb-1 text-sm font-medium">{{ $label }}</label>
                    <input type="{{ $field === 'dob' ? 'date' : 'text' }}" wire:model.defer="{{ $field }}"
                        id="{{ $field }}"
                        class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition" />
                    <p class="text-xs text-slate-500 mt-1">
                        @if ($field === 'phone')
                            Enter your mobile number for contact and verification.
                        @elseif ($field === 'dob')
                            Your date of birth helps us verify your eligibility.
                        @endif
                    </p>
                    @error($field)
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach

            <div>
                <label for="gender" class="block mb-1 text-sm font-medium">Gender</label>
                <select id="gender" wire:model.defer="gender"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="others">Others</option>
                </select>
                <p class="text-xs text-slate-500 mt-1">Select your gender for demographic purposes.</p>
                @error('gender')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="profile_photo" class="block mb-1 text-sm font-medium">Profile Photo</label>
                <input type="file" wire:model="profile_photo"
                    class="w-full file:bg-indigo-600 file:text-white file:px-4 file:py-2 file:rounded-md bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md" />
                <p class="text-xs text-slate-500 mt-1">Upload a recent photo for your profile. Max size: 2MB. JPG/PNG
                    only.</p>
                @error('profile_photo')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- ID Proof --}}
        <div>
            <label for="id_proof_path" class="block mb-1 text-sm font-medium">Government ID Proof</label>
            <input type="file" wire:model="id_proof_path"
                class="w-full file:bg-indigo-600 file:text-white file:px-4 file:py-2 file:rounded-md bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md" />
            <p class="text-xs text-slate-500 mt-1">Upload a government-issued ID for verification. Max size: 2MB.
                PDF/JPG/PNG accepted.</p>
            @error('id_proof_path')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Address Info --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ([['permanent_address', 'Permanent Address'], ['current_address', 'Current Address'], ['city', 'City'], ['state', 'State'], ['zip', 'ZIP Code']] as [$field, $label])
                <div>
                    <label for="{{ $field }}" class="block mb-1 text-sm font-medium">{{ $label }}</label>
                    <input type="text" wire:model.defer="{{ $field }}" id="{{ $field }}"
                        class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition" />
                    <p class="text-xs text-slate-500 mt-1">
                        @if ($field === 'permanent_address')
                            Your official address for records.
                        @elseif ($field === 'current_address')
                            Where you currently reside.
                        @elseif ($field === 'city')
                            City of your residence.
                        @elseif ($field === 'state')
                            State of your residence.
                        @elseif ($field === 'zip')
                            Postal/ZIP code for your area.
                        @endif
                    </p>
                    @error($field)
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach
        </div>

        {{-- Professional Info --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ([['profession', 'Profession'], ['spouse_name', 'Spouse Name'], ['spouse_email', 'Spouse Email'], ['spouse_phone', 'Spouse Phone'], ['spouse_profession', 'Spouse Profession']] as [$field, $label])
                <div>
                    <label for="{{ $field }}"
                        class="block mb-1 text-sm font-medium">{{ $label }}</label>
                    <input type="{{ Str::contains($field, 'email') ? 'email' : 'text' }}"
                        wire:model.defer="{{ $field }}" id="{{ $field }}"
                        class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
                    <p class="text-xs text-slate-500 mt-1">
                        @if ($field === 'profession')
                            Your current occupation or job title.
                        @elseif ($field === 'spouse_name')
                            Name of your spouse/partner (if applicable).
                        @elseif ($field === 'spouse_email')
                            Spouse's email address (optional).
                        @elseif ($field === 'spouse_phone')
                            Spouse's phone number (optional).
                        @elseif ($field === 'spouse_profession')
                            Spouse's occupation (optional).
                        @endif
                    </p>
                    @error($field)
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach

            <div>
                <label for="monthly_income" class="block mb-1 text-sm font-medium">Monthly Income</label>
                <select wire:model.defer="monthly_income" id="monthly_income"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="">Select</option>
                    <option value="<50K">&lt; ₹50K</option>
                    <option value="50–100K">₹50–100K</option>
                    <option value="100–200K">₹100–200K</option>
                    <option value="200K+">₹200K+</option>
                </select>
                @error('monthly_income')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Preferences --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ([['number_of_children', 'Number of Children'], ['number_needing_care', 'Children Needing Care']] as [$field, $label])
                <div>
                    <label for="{{ $field }}"
                        class="block mb-1 text-sm font-medium">{{ $label }}</label>
                    <input type="number" wire:model.defer="{{ $field }}" id="{{ $field }}"
                        class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500" />
                    <p class="text-xs text-slate-500 mt-1">
                        @if ($field === 'number_of_children')
                            Total children you have (1-10).
                        @elseif ($field === 'number_needing_care')
                            How many children need care? (1-10).
                        @endif
                    </p>
                    @error($field)
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach

            @foreach ([['preferred_drop_off_time', 'Drop-off Time', ['morning' => 'Morning', 'afternoon' => 'Afternoon', 'evening' => 'Evening', 'full_day' => 'Full Day']], ['preferred_type_of_caregiver', 'Caregiver Type', ['newlywed' => 'Newlywed', 'professional' => 'Professional', 'parent' => 'Parent', 'senior' => 'Senior', 'any' => 'Any']], ['preferred_radius', 'Preferred Radius (km)', ['2-3' => '2–3 km', '3-4' => '3–4 km', '4-5' => '4–5 km']]] as [$field, $label, $options])
                <div>
                    <label for="{{ $field }}"
                        class="block mb-1 text-sm font-medium">{{ $label }}</label>
                    <select wire:model.defer="{{ $field }}" id="{{ $field }}"
                        class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select</option>
                        @foreach ($options as $value => $text)
                            <option value="{{ $value }}">{{ $text }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-slate-500 mt-1">
                        @if ($field === 'preferred_drop_off_time')
                            When do you prefer to drop off your child(ren)?
                        @elseif ($field === 'preferred_type_of_caregiver')
                            Choose the type of CareBuddy you prefer. See info board above for details.
                        @elseif ($field === 'preferred_radius')
                            How far are you willing to travel for care? (in km)
                        @endif
                    </p>
                    @error($field)
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach
        </div>

        {{-- Other Fields --}}
        <div>
            <label class="flex items-center space-x-2">
                <input type="checkbox" wire:model.defer="needs_special_needs_support"
                    class="rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500" />
                <span>Special needs support required</span>
            </label>
            @error('needs_special_needs_support')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="reason_for_service" class="block mb-1 text-sm font-medium">Reason for Seeking Service</label>
            <textarea wire:model.defer="reason_for_service" id="reason_for_service" rows="3"
                class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500"></textarea>
            <p class="text-xs text-slate-500 mt-1">Share why you are seeking a CareBuddy (optional, but helps us match
                you better).</p>
            @error('reason_for_service')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Emergency Contact --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="emergency_contact_name" class="block mb-1 text-sm font-medium">Emergency Contact
                    Name</label>
                <input type="text" wire:model.defer="emergency_contact_name" id="emergency_contact_name"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500" />
                <p class="text-xs text-slate-500 mt-1">Name of the person to contact in case of emergency.</p>
                @error('emergency_contact_name')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="emergency_contact_phone" class="block mb-1 text-sm font-medium">Emergency Contact
                    Phone</label>
                <input type="text" wire:model.defer="emergency_contact_phone" id="emergency_contact_phone"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500" />
                <p class="text-xs text-slate-500 mt-1">Phone number of the emergency contact.</p>
                @error('emergency_contact_phone')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Terms and Submit --}}
        <div class="flex items-start space-x-3">
            <input type="checkbox" wire:model.defer="terms_accepted" id="terms_accepted" class="mr-2">
            <label for="terms_accepted" class="text-sm">I accept the <a href="#" class="underline">terms and
                    conditions</a>.</label>
            <p class="text-xs text-slate-500 mt-1">You must accept the terms to use our service.</p>
            @error('terms_accepted')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-4">
            <button type="button" wire:click="saveDraft"
                class="px-6 py-2 border border-slate-300 dark:border-slate-600 rounded-md bg-white dark:bg-slate-800 text-slate-900 dark:text-white transition
    hover:bg-green-50 hover:border-green-500 hover:text-green-800 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-green-400 cursor-pointer">
                <svg class="inline w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                Save & Resume Later
            </button>
            <button type="submit"
                class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition font-semibold cursor-pointer">
                Submit
            </button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.addEventListener('draft-saved', function () {
        Swal.fire({
            icon: 'success',
            title: 'Draft Saved!',
            text: 'You can safely close this page and resume registration later.',
            confirmButtonColor: '#16a34a'
        });
    });
</script>
