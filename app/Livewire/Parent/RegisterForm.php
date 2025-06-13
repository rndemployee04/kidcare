<?php

namespace App\Livewire\Parent;

use Livewire\Component;
use App\Models\Parents;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Livewire\TemporaryUploadedFile;

#[Layout('components.layouts.onboarding')]
class RegisterForm extends Component
{
    use WithFileUploads;

    // Personal Info
    public string $phone = '';
    public string $dob = '';
    public string $gender = 'male';
    public $profile_photo;
    public $id_proof_path;

    // Address Info
    public string $permanent_address = '';
    public string $current_address = '';
    public string $city = '';
    public string $state = '';
    public string $zip = '';

    // Professional Info
    public string $profession = '';
    public ?string $spouse_name = null;
    public ?string $spouse_email = null;
    public ?string $spouse_phone = null;
    public ?string $spouse_profession = null;
    public ?string $monthly_income = null;

    // Preferences
    public int $number_of_children = 1;
    public int $number_needing_care = 1;
    public string $preferred_drop_off_time = 'full_day';
    public string $preferred_type_of_caregiver = 'any';
    public string $preferred_radius = '2-3';
    public bool $needs_special_needs_support = false;
    public ?string $reason_for_service = null;

    // Emergency & Agreement
    public string $emergency_contact_name = '';
    public string $emergency_contact_phone = '';
    public bool $terms_accepted = false;

    public function mount()
    {
        if (!Auth::user()?->isParent()) {
            return redirect()->route('home');
        }

        $parent = Parents::where('user_id', Auth::id())->first();
        if ($parent) {
            foreach ($this->fillableFields() as $field) {
                if (isset($parent->$field)) {
                    $this->$field = $parent->$field;
                }
            }
        }
    }

    protected function fillableFields(): array
    {
        return [
            'phone',
            'dob',
            'gender',
            'profile_photo',
            'id_proof_path',
            'permanent_address',
            'current_address',
            'city',
            'state',
            'zip',
            'profession',
            'spouse_name',
            'spouse_email',
            'spouse_phone',
            'spouse_profession',
            'monthly_income',
            'number_of_children',
            'number_needing_care',
            'preferred_drop_off_time',
            'preferred_type_of_caregiver',
            'preferred_radius',
            'needs_special_needs_support',
            'reason_for_service',
            'emergency_contact_name',
            'emergency_contact_phone',
            'terms_accepted',
        ];
    }

    public function saveDraft()
    {
        // Validate file inputs
        $this->validate([
            'profile_photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'id_proof_path' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ]);

        $data = $this->only($this->fillableFields());
        $data['user_id'] = Auth::id();

        // Store profile photo if uploaded
        if ($this->profile_photo && !is_string($this->profile_photo)) {
            \Log::info('Storing draft profile photo: ' . $this->profile_photo->getClientOriginalName());
            $path = $this->profile_photo->store('profile_photos', 'public');
            $data['profile_photo'] = $path;
            $this->profile_photo = $path;
        }

        // Store ID proof if uploaded
        if ($this->id_proof_path && !is_string($this->id_proof_path)) {
            \Log::info('Storing draft ID proof: ' . $this->id_proof_path->getClientOriginalName());
            $path = $this->id_proof_path->store('id_proofs', 'public');
            $data['id_proof_path'] = $path;
            $this->id_proof_path = $path;
        }

        // Normalize null values for optional fields
        foreach (['phone', 'dob', 'gender', 'permanent_address', 'current_address', 'city', 'state', 'zip', 'profession', 'number_of_children', 'number_needing_care', 'preferred_drop_off_time', 'preferred_type_of_caregiver', 'preferred_radius', 'emergency_contact_name', 'emergency_contact_phone'] as $field) {
            if (empty($data[$field])) {
                $data[$field] = null;
            }
        }

        Parents::updateOrCreate(
            ['user_id' => Auth::id()],
            $data
        );

        session()->flash('message', 'Draft saved! You can resume later.');
        $this->dispatch('draft-saved');
    }

    public function submit()
    {
        $validated = $this->validate([
            // Personal
            'phone' => 'required|string|max_digits:13|min_digits:10',
            'dob' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $minAge = 18;
                    $minDate = now()->subYears($minAge);
                    if ($value > $minDate) {
                        $fail('You must be at least 18 years old to register.');
                    }
                },
            ],
            'gender' => 'required|in:male,female,others',
            'profile_photo' => [
                function ($attribute, $value, $fail) {
                    if (!$value) {
                        // Allow null for profile_photo (optional)
                        return;
                    } elseif (is_string($value)) {
                        // File already saved, no further validation needed
                        return;
                    } elseif (!in_array($value->getClientOriginalExtension(), ['jpg', 'jpeg', 'png'])) {
                        $fail('Profile photo must be a JPG or PNG file.');
                    } elseif ($value->getSize() > 2048 * 1024) {
                        $fail('Profile photo must not exceed 2MB.');
                    }
                },
            ],
            'id_proof_path' => [
                function ($attribute, $value, $fail) {
                    if (!$value) {
                        $fail('ID proof is required.');
                    } elseif (is_string($value)) {
                        return;
                    } elseif (!in_array($value->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'pdf'])) {
                        $fail('ID proof must be a JPG, PNG, or PDF file.');
                    } elseif ($value->getSize() > 4096 * 1024) {
                        $fail('ID proof must not exceed 4MB.');
                    }
                },
            ],
            // Address
            'permanent_address' => 'required|string',
            'current_address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required|string',
            // Professional
            'profession' => 'required|string',
            'spouse_name' => 'nullable|string',
            'spouse_email' => 'nullable|email',
            'spouse_phone' => 'nullable|string|max_digits:13|min_digits:10',
            'spouse_profession' => 'nullable|string',
            'monthly_income' => 'nullable|in:<50K,50–100K,100–200K,200K+',
            // Preferences
            'number_of_children' => 'required|integer|min:1|max:10',
            'number_needing_care' => 'required|integer|min:1|max:10',
            'preferred_drop_off_time' => 'required|in:morning,afternoon,evening,full_day',
            'preferred_type_of_caregiver' => 'required|in:newlywed,professional,parent,senior,any',
            'preferred_radius' => 'required|in:2-3,3-4,4-5',
            'needs_special_needs_support' => 'boolean',
            'reason_for_service' => 'nullable|string',
            // Emergency
            'emergency_contact_name' => 'required|string',
            'emergency_contact_phone' => 'required|string|max_digits:13|min_digits:10',
            // Terms
            'terms_accepted' => 'accepted',
        ]);

        $validated['user_id'] = Auth::id();

        // Store new files only if they are UploadedFile instances
        if ($this->profile_photo && !is_string($this->profile_photo)) {
            \Log::info('Storing profile photo: ' . $this->profile_photo->getClientOriginalName());
            $path = $this->profile_photo->store('profile_photos', 'public');
            $validated['profile_photo'] = $path;
        } else {
            $validated['profile_photo'] = $this->profile_photo;
        }

        if ($this->id_proof_path && !is_string($this->id_proof_path)) {
            \Log::info('Storing ID proof: ' . $this->id_proof_path->getClientOriginalName());
            $path = $this->id_proof_path->store('id_proofs', 'public');
            $validated['id_proof_path'] = $path;
        } else {
            $validated['id_proof_path'] = $this->id_proof_path;
        }

        Parents::updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        $user = Auth::user();
        $user->registration_complete = true;
        $user->save();

        return redirect()->route('parent.application.status');
    }

    public function render()
    {
        return view('parent.register-form');
    }
}