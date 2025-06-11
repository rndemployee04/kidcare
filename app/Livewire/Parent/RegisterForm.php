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
                if (isset($parent[$field])) {
                    $this->$field = $parent[$field];
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
        $data = $this->only($this->fillableFields());
        $data['user_id'] = Auth::id();

        if ($this->profile_photo instanceof TemporaryUploadedFile) {
            \Log::info('Storing draft profile photo: ' . $this->profile_photo->getClientOriginalName());
            $data['profile_photo'] = $this->profile_photo->store('profile_photos', 'public');
            $this->profile_photo = $data['profile_photo'];
        }

        if ($this->id_proof_path instanceof TemporaryUploadedFile) {
            \Log::info('Storing draft ID proof: ' . $this->id_proof_path->getClientOriginalName());
            $data['id_proof_path'] = $this->id_proof_path->store('id_proofs', 'public');
            $this->id_proof_path = $data['id_proof_path'];
        }

        // Normalize null values
        foreach (['phone', 'dob', 'gender', 'id_proof_path', 'permanent_address', 'current_address', 'city', 'state', 'zip', 'profession', 'number_of_children', 'number_needing_care', 'preferred_drop_off_time', 'preferred_type_of_caregiver', 'preferred_radius', 'emergency_contact_name', 'emergency_contact_phone', 'terms_accepted'] as $required) {
            if (empty($data[$required])) {
                $data[$required] = null;
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
            'phone' => 'required|string|max_digits:13',
            'dob' => ['required', 'date', function($attribute, $value, $fail) {
                $minAge = 18;
                $minDate = now()->subYears($minAge);
                if ($value > $minDate) {
                    $fail('You must be at least 18 years old to register.');
                }
            }],
            'gender' => 'required|in:male,female,others',
            'profile_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',

            // ID Proof
            'id_proof_path' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',

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
            'spouse_phone' => 'nullable|string',
            'spouse_profession' => 'nullable|string',
            'monthly_income' => 'nullable|in:<50K,50–100K,100–200K,200K+',

            // Preferences
            'number_of_children' => ['required', 'integer', 'min:1', 'max:10'],
            'number_needing_care' => 'required|integer|min:1|max:10',
            'preferred_drop_off_time' => 'required|in:morning,afternoon,evening,full_day',
            'preferred_type_of_caregiver' => 'required|in:newlywed,professional,parent,senior,any',
            'preferred_radius' => 'required|in:2-3,3-4,4-5',
            'needs_special_needs_support' => 'boolean',
            'reason_for_service' => 'nullable|string',

            // Emergency
            'emergency_contact_name' => 'required|string',
            'emergency_contact_phone' => 'required|string|max_digits:13',

            // Terms
            'terms_accepted' => 'accepted',
        ]);

        $validated['user_id'] = Auth::id();

        // Always store uploaded files if present
        if ($this->profile_photo) {
            $validated['profile_photo'] = $this->profile_photo->store('profile_photos', 'public');
        }

        if ($this->id_proof_path) {
            $validated['id_proof_path'] = $this->id_proof_path->store('id_proofs', 'public');
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
