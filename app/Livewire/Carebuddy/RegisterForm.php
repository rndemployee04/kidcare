<?php

namespace App\Livewire\Carebuddy;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\CareBuddy;
use Illuminate\Support\Facades\Auth;
#[Layout('components.layouts.onboarding')]

class RegisterForm extends Component
{
    use \Livewire\WithFileUploads;

    // CareBuddy Info
    public string $category = '';
    public string $dob = '';
    public string $phone = '';
    public string $gender = 'male';
    public string $profile_photo = '';
    public string $document_path = '';
    public string $id_proof_path = '';
    public string $selfie_path = '';
    public string $permanent_address = '';
    public string $current_address = '';
    public string $city = '';
    public string $state = '';
    public string $zip = '';
    public string $service_radius = '2-3';
    public string $child_age_limit = 'all';
    public bool $willing_to_take_insurance = false;
    public bool $background_check_consent = false;
    public bool $terms_accepted = false;
    public array $availability = [];

    public function mount()
    {
        if (!Auth::user()?->isCareBuddy()) {
            return redirect()->route('carebuddy.dashboard');
        }
        // Load draft if exists
        $carebuddy = \App\Models\CareBuddy::where('user_id', Auth::id())->first();
        if ($carebuddy) {
            foreach ($this->fillableFields() as $field) {
                if (isset($carebuddy[$field])) {
                    $this->$field = $carebuddy[$field];
                }
            }
        }
    }

    // Helper: list of all fillable fields
    protected function fillableFields(): array
    {
        return [
            'category',
            'dob',
            'phone',
            'gender',
            'profile_photo',
            'id_proof_path',
            'selfie_path',
            'permanent_address',
            'current_address',
            'city',
            'state',
            'zip',
            'service_radius',
            'child_age_limit',
            'willing_to_take_insurance',
            'background_check_consent',
            'terms_accepted',
            'availability',
        ];
    }

    public function saveDraft()
    {
        $data = $this->only($this->fillableFields());
        $data['user_id'] = Auth::id();

        // Handle file uploads (if any)
        if ($this->profile_photo instanceof \Livewire\TemporaryUploadedFile) {
            $data['profile_photo'] = $this->profile_photo->store('profile_photos', 'public');
        }
        if ($this->id_proof_path instanceof \Livewire\TemporaryUploadedFile) {
            $data['id_proof_path'] = $this->id_proof_path->store('id_proofs', 'public');
        }
        if ($this->selfie_path instanceof \Livewire\TemporaryUploadedFile) {
            $data['selfie_path'] = $this->selfie_path->store('selfies', 'public');
        }

        // Set empty strings to null for DB-required fields (must be nullable in DB for drafts to work)
        foreach ([
            'category','dob','phone','gender','id_proof_path','permanent_address','current_address','city','state','zip','service_radius','child_age_limit','selfie_path'
        ] as $required) {
            if (empty($data[$required])) {
                $data[$required] = null;
            }
        }
        // NOTE: The following fields must be nullable in your care_buddies table for drafts to work:
        // category, dob, phone, gender, id_proof_path, permanent_address, current_address, city, state, zip, service_radius, child_age_limit, selfie_path

        // Ensure availability is always an array
        if (!is_array($data['availability'])) {
            $data['availability'] = $data['availability'] ? [$data['availability']] : [];
        }

        \App\Models\CareBuddy::updateOrCreate(
            ['user_id' => Auth::id()],
            $data
        );

        session()->flash('message', 'Draft saved! You can resume later.');
        $this->dispatch('draft-saved');
    }

    public function submit()
    {
        $validated = $this->validate([
            'category' => 'required|in:newlywed,professional,parent,senior',
            'dob' => 'required|date',
            'phone' => 'required|string',
            'gender' => 'required|in:male,female,others',
            'profile_photo' => 'nullable|string',
            'document_path' => 'nullable|string',
            'id_proof_path' => 'required|string',
            'selfie_path' => 'required|string',
            'permanent_address' => 'required|string',
            'current_address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required|string',
            'service_radius' => 'required|in:2-3,3-4,4-5',
            'child_age_limit' => 'required|in:2-3,3-5,5-8,8-10,all',
            'willing_to_take_insurance' => 'boolean',
            'background_check_consent' => 'boolean',
            'terms_accepted' => 'accepted',
            'availability' => 'required|array|min:1',
        ]);

        $validated['user_id'] = Auth::id();

        // Handle file uploads (if any)
        if ($this->profile_photo instanceof \Livewire\TemporaryUploadedFile) {
            $validated['profile_photo'] = $this->profile_photo->store('profile_photos', 'public');
        }
        if ($this->id_proof_path instanceof \Livewire\TemporaryUploadedFile) {
            $validated['id_proof_path'] = $this->id_proof_path->store('id_proofs', 'public');
        }
        if ($this->selfie_path instanceof \Livewire\TemporaryUploadedFile) {
            $validated['selfie_path'] = $this->selfie_path->store('selfies', 'public');
        }

        // Ensure availability is always an array
        if (!is_array($validated['availability'])) {
            $validated['availability'] = $validated['availability'] ? [$validated['availability']] : [];
        }

        // Upsert carebuddy profile (overwrite draft if exists)
        \App\Models\CareBuddy::updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        // Mark registration as complete
        $user = Auth::user();
        $user->registration_complete = true;
        $user->save();

        return redirect()->route('carebuddy.dashboard');
    }

    public function render()
    {
        return view('carebuddy.register-form');
    }
}

