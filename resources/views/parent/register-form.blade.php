<div class="max-w-4xl mx-auto px-6 py-10 text-slate-900 dark:text-slate-100 bg-white shadow-xl rounded overflow-hidden">
    <div class="top-hed flex items-center mb-5">
        <x-auth-header :title="__('Parent Profile')" :description="__('Fill in your details below')" />
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
    <form wire:submit.prevent="submit" class="space-y-8" enctype="multipart/form-data">
        <h2 class="text-xl font-semibold mb-6 border-b border-slate-200 dark:border-slate-700 pb-2">Personal Information
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ([['phone', 'Phone'], ['dob', 'Date of Birth']] as [$field, $label])
                <div>
                    <label for="{{ $field }}" class="block mb-1 text-sm font-medium">{{ $label }} <span
                            class="text-red-500">*</span></label>
                    <input type="{{ $field === 'dob' ? 'date' : 'text' }}" wire:model.defer="{{ $field }}" id="{{ $field }}"
                        class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition"
                        required @if($field === 'phone') oninput="{
                                const maxLength = 13;
                                if (this.value.length > maxLength) {
                                    this.value = this.value.slice(0, maxLength);
                                }
                                this.value = this.value.replace(/[^0-9]/g, '');
                            }" maxlength="13" pattern="[0-9]*" title="Please enter a valid phone number (10-13 digits)"
                        @endif />
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        @if ($field === 'phone')
                            Enter a mobile number (10-13 digits) for contact and verification.
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
                <label for="gender" class="block mb-1 text-sm font-medium">Gender <span
                        class="text-red-500">*</span></label>
                <select id="gender" wire:model.defer="gender"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="others">Others</option>
                </select>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Select your gender for demographic purposes.
                </p>
                @error('gender')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="profile_photo" class="block mb-1 text-sm font-medium">Profile Photo</label>
                <input type="file" wire:model="profile_photo" id="profile_photo" accept="image/*"
                    class="w-full file:bg-orange-400 file:text-white file:px-4 file:py-2 file:rounded-md file:border-0 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md" />
                @if($profile_photo && is_string($profile_photo))
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Current file: {{ basename($profile_photo) }}
                    </p>
                @endif
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Upload a recent photo for your profile. Max
                    size: 2MB. JPG/PNG only.</p>
                @error('profile_photo')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <h2 class="text-xl font-semibold mb-6 border-b border-slate-200 dark:border-slate-700 pb-2">Identity
            Verification</h2>

        <div class="!mb-[1.5rem]">
            <label for="id_proof_path" class="block mb-1 text-sm font-medium">ID Proof <span
                    class="text-red-500">*</span></label>
            <input type="file" wire:model="id_proof_path" id="id_proof_path" accept="image/*,.pdf"
                class="w-full file:bg-orange-400 file:text-white file:px-4 file:py-2 file:rounded-md file:border-0 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md"
                required />
            @if($id_proof_path && is_string($id_proof_path))
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Current file: {{ basename($id_proof_path) }}</p>
            @endif
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Government issued ID (Aadhaar, Passport, etc.)
                Max size: 4MB. JPG/PNG/PDF only.</p>
            @error('id_proof_path')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <h2 class="text-xl font-semibold mb-6 border-b border-slate-200 dark:border-slate-700 pb-2">Address Information
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ([['permanent_address', 'Permanent Address'], ['current_address', 'Current Address'], ['city', 'City'], ['state', 'State'], ['zip', 'ZIP Code']] as [$field, $label])
                <div>
                    <label for="{{ $field }}" class="block mb-1 text-sm font-medium">{{ $label }} <span
                            class="text-red-500">*</span></label>
                    <input type="text" wire:model.defer="{{ $field }}" id="{{ $field }}"
                        class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition"
                        required />
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
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
        <div class="flex items-center my-3">
            <div class="flex-grow h-px bg-slate-300 dark:bg-slate-600"></div>
            <span class="mx-3 text-sm text-slate-500 dark:text-slate-400">or select your location on the map</span>
            <div class="flex-grow h-px bg-slate-300 dark:bg-slate-600"></div>
        </div>
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
        <h2 class="text-xl font-semibold mb-6 border-b border-slate-200 dark:border-slate-700 pb-2">Professional
            Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ([['profession', 'Profession'], ['spouse_name', 'Spouse Name'], ['spouse_email', 'Spouse Email'], ['spouse_phone', 'Spouse Phone'], ['spouse_profession', 'Spouse Profession']] as [$field, $label])
                <div>
                    <label for="{{ $field }}" class="block mb-1 text-sm font-medium">{{ $label }}
                        {{ $field === 'profession' ? '<span class="text-red-500">*</span>' : '' }}</label>
                    <input type="{{ Str::contains($field, 'email') ? 'email' : 'text' }}" wire:model.defer="{{ $field }}"
                        id="{{ $field }}"
                        class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition"
                        @if($field === 'profession') required @endif @if($field === 'spouse_phone') oninput="{
                                const maxLength = 13;
                                if (this.value.length > maxLength) {
                                    this.value = this.value.slice(0, maxLength);
                                }
                                this.value = this.value.replace(/[^0-9]/g, '');
                            }" maxlength="13" pattern="[0-9]*" title="Please enter a valid phone number (10-13 digits)"
                        @endif />
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        @if ($field === 'profession')
                            Your current occupation or job title.
                        @elseif ($field === 'spouse_name')
                            Name of your spouse/partner (if applicable).
                        @elseif ($field === 'spouse_email')
                            Spouse's email address (optional).
                        @elseif ($field === 'spouse_phone')
                            Spouse's phone number (10-13 digits, optional).
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
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition">
                    <option value="">Select</option>
                    <option value="<50K">
                        < $50K</option>
                    <option value="50–100K">$50–100K</option>
                    <option value="100–200K">$100–200K</option>
                    <option value="200K+">$200K+</option>
                </select>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Your household's monthly income (optional).
                </p>
                @error('monthly_income')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <h2 class="text-xl font-semibold mb-6 border-b border-slate-200 dark:border-slate-700 pb-2">Preferences</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ([['number_of_children', 'Number of Children'], ['number_needing_care', 'Children Needing Care']] as [$field, $label])
                <div>
                    <label for="{{ $field }}" class="block mb-1 text-sm font-medium">{{ $label }} <span
                            class="text-red-500">*</span></label>
                    <input type="number" wire:model.defer="{{ $field }}" id="{{ $field }}"
                        class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition"
                        required min="1" max="10" oninput="{
                                    const max = 10;
                                    if (this.value > max) {
                                        this.value = max;
                                    }
                                }" />
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
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
                    <flux:heading class="flex items-center gap-2">
                        {{ $label }} <span class="text-red-500">*</span>
                        @if ($field === 'preferred_drop_off_time')
                            <flux:tooltip toggleable>
                                <flux:button icon="information-circle" size="sm" variant="ghost" />
                                <flux:tooltip.content class="max-w-[20rem] space-y-2 !bg-transparent">
                                    <div
                                        class="bg-orange-100 dark:bg-orange-900 border-l-4 border-orange-500 dark:border-orange-600 text-orange-800 dark:text-orange-100 p-4 rounded shadow flex items-start gap-3">
                                        <svg class="w-6 h-6 mt-1 text-orange-500 dark:text-orange-300" fill="none"
                                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13 16h-1v-4h-1m1-4h.01M12 20.5a8.38 8.38 0 100-16.76 8.38 8.38 0 000 16.76z" />
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
                                </flux:tooltip.content>
                            </flux:tooltip>
                        @elseif ($field === 'preferred_type_of_caregiver')
                            <flux:tooltip toggleable>
                                <flux:button icon="information-circle" size="sm" variant="ghost" />
                                <flux:tooltip.content class="max-w-[20rem] space-y-2 !bg-transparent">
                                    <div
                                        class="bg-orange-100 dark:bg-orange-900 border-l-4 border-orange-500 dark:border-orange-600 text-orange-800 dark:text-yellow-100 p-4 rounded shadow flex items-start gap-3">
                                        <svg class="w-6 h-6 mt-1 text-orange-500 dark:text-orange-300" fill="none"
                                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13 16h-1v-4h-1m1-4h.01M12 20.5a8.38 8.38 0 100-16.76 8.38 8.38 0 000 16.76z" />
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
                                </flux:tooltip.content>
                            </flux:tooltip>
                        @endif
                    </flux:heading>
                    <select wire:model.defer="{{ $field }}" id="{{ $field }}"
                        class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition"
                        required>
                        <option value="">Select</option>
                        @foreach ($options as $value => $text)
                            <option value="{{ $value }}">{{ $text }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        @if ($field === 'preferred_drop_off_time')
                            When do you prefer to drop off your child(ren)?
                        @elseif ($field === 'preferred_type_of_caregiver')
                            Choose the type of CareBuddy you prefer.
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
        <div>
            <label class="flex items-center space-x-2">
                <input type="checkbox" wire:model.defer="needs_special_needs_support"
                    class="rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500" />
                <span>Special needs support required</span>
            </label>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Check if your child(ren) require special needs
                support.</p>
            @error('needs_special_needs_support')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="reason_for_service" class="block mb-1 text-sm font-medium">Reason for Seeking Service</label>
            <textarea wire:model.defer="reason_for_service" id="reason_for_service" rows="3"
                class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition"></textarea>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Share why you are seeking a CareBuddy (optional,
                but helps us match you better).</p>
            @error('reason_for_service')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <h2 class="text-xl font-semibold mb-6 border-b border-slate-200 dark:border-slate-700 pb-2">Emergency Contact
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="emergency_contact_name" class="block mb-1 text-sm font-medium">Emergency Contact Name <span
                        class="text-red-500">*</span></label>
                <input type="text" wire:model.defer="emergency_contact_name" id="emergency_contact_name"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition"
                    required />
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Name of the person to contact in case of
                    emergency.</p>
                @error('emergency_contact_name')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="emergency_contact_phone" class="block mb-1 text-sm font-medium">Emergency Contact Phone
                    <span class="text-red-500">*</span></label>
                <input type="text" wire:model.defer="emergency_contact_phone" id="emergency_contact_phone"
                    class="w-full px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-300 dark:border-slate-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition"
                    required oninput="{
                                const maxLength = 13;
                                if (this.value.length > maxLength) {
                                    this.value = this.value.slice(0, maxLength);
                                }
                                this.value = this.value.replace(/[^0-9]/g, '');
                            }" maxlength="13" pattern="[0-9]*"
                    title="Please enter a valid phone number (10-13 digits)" />
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Phone number (10-13 digits) of the emergency
                    contact.</p>
                @error('emergency_contact_phone')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <h2 class="text-xl font-semibold mb-6 border-b border-slate-200 dark:border-slate-700 pb-2">Agreement</h2>
        <div class="flex space-x-3 items-center">
            <input type="checkbox" wire:model.defer="terms_accepted" id="terms_accepted"
                class="rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500" required />
            <label for="terms_accepted" class="text-sm">I accept the <a href="#" class="underline">terms and
                    conditions</a> <span class="text-red-500">*</span>.</label>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">You must accept the terms to use our service.</p>
            @error('terms_accepted')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex justify-end space-x-4">
            <button type="button" wire:click="saveDraft"
                class="px-6 py-2 border border-slate-300 dark:border-slate-600 rounded-md bg-white dark:bg-slate-800 text-slate-900 dark:text-white transition hover:bg-green-50 hover:border-green-500 hover:text-green-800 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-green-400 cursor-pointer">
                <svg class="inline w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                Save & Resume Later
            </button>
            <button type="submit"
                class="px-6 py-2 bg-orange-400 hover:bg-orange-500 text-white rounded-md transition font-semibold cursor-pointer">
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
