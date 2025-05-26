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
    public $profile_photo;
    public $certificate_path;
    public $id_proof_path;
    public $selfie_path;
    public $marriage_certificate_path;
    public $birth_certificate_path;
    public $child_birth_certificate_path;
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
            return redirect()->route('home');
        }
        // Load draft if exists
        $carebuddy = CareBuddy::where('user_id', Auth::id())->first();
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
            'certificate_path',
            'marriage_certificate_path',
            'birth_certificate_path',
            'child_birth_certificate_path',
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

        // Store and log profile photo
        \Log::info('Storing profile photo: ' . $this->profile_photo->getClientOriginalName());
        $path = $this->profile_photo->store('profile_photos', 'public');
        \Log::info('Stored profile photo at: ' . $path);
        $data['profile_photo'] = $path;
        $this->profile_photo = $path;

        // Store and log ID proof
        \Log::info('Storing ID proof: ' . $this->id_proof_path->getClientOriginalName());
        $path = $this->id_proof_path->store('id_proofs', 'public');
        \Log::info('Stored ID proof at: ' . $path);
        $data['id_proof_path'] = $path;
        $this->id_proof_path = $path;

        // Store and log selfie
        \Log::info('Storing selfie: ' . $this->selfie_path->getClientOriginalName());
        $path = $this->selfie_path->store('selfies', 'public');
        \Log::info('Stored selfie at: ' . $path);
        $data['selfie_path'] = $path;
        $this->selfie_path = $path;

        // OPTIONAL: store certificates if uploaded
        if ($this->certificate_path) {
            \Log::info('Storing certificate: ' . $this->certificate_path->getClientOriginalName());
            $path = $this->certificate_path->store('certificates', 'public');
            \Log::info('Stored certificate at: ' . $path);
            $data['certificate_path'] = $path;
            $this->certificate_path = $path;
        }

        if ($this->marriage_certificate_path) {
            \Log::info('Storing marriage certificate: ' . $this->marriage_certificate_path->getClientOriginalName());
            $path = $this->marriage_certificate_path->store('certificates', 'public');
            \Log::info('Stored marriage certificate at: ' . $path);
            $data['marriage_certificate_path'] = $path;
            $this->marriage_certificate_path = $path;
        }

        if ($this->birth_certificate_path) {
            \Log::info('Storing birth certificate: ' . $this->birth_certificate_path->getClientOriginalName());
            $path = $this->birth_certificate_path->store('certificates', 'public');
            \Log::info('Stored birth certificate at: ' . $path);
            $data['birth_certificate_path'] = $path;
            $this->birth_certificate_path = $path;
        }

        if ($this->child_birth_certificate_path) {
            \Log::info('Storing child birth certificate: ' . $this->child_birth_certificate_path->getClientOriginalName());
            $path = $this->child_birth_certificate_path->store('certificates', 'public');
            \Log::info('Stored child birth certificate at: ' . $path);
            $data['child_birth_certificate_path'] = $path;
            $this->child_birth_certificate_path = $path;
        }

        // Set empty strings to null for DB-required fields
        foreach (['category', 'dob', 'phone', 'gender', 'id_proof_path', 'permanent_address', 'current_address', 'city', 'state', 'zip', 'service_radius', 'child_age_limit', 'selfie_path'] as $field) {
            if (empty($data[$field])) {
                $data[$field] = null;
            }
        }

        // Ensure availability is always an array
        if (!is_array($data['availability'])) {
            $data['availability'] = $data['availability'] ? [$data['availability']] : [];
        }

        CareBuddy::updateOrCreate(
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
            'profile_photo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'id_proof_path' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'selfie_path' => 'required|file|mimes:jpg,jpeg,png|max:2048',
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

        // Store and log profile photo
        \Log::info('Storing profile photo: ' . $this->profile_photo->getClientOriginalName());
        $path = $this->profile_photo->store('profile_photos', 'public');
        \Log::info('Stored profile photo at: ' . $path);
        $validated['profile_photo'] = $path;
        $this->profile_photo = $path;

        // Store and log ID proof
        \Log::info('Storing ID proof: ' . $this->id_proof_path->getClientOriginalName());
        $path = $this->id_proof_path->store('id_proofs', 'public');
        \Log::info('Stored ID proof at: ' . $path);
        $validated['id_proof_path'] = $path;
        $this->id_proof_path = $path;

        // Store and log selfie
        \Log::info('Storing selfie: ' . $this->selfie_path->getClientOriginalName());
        $path = $this->selfie_path->store('selfies', 'public');
        \Log::info('Stored selfie at: ' . $path);
        $validated['selfie_path'] = $path;
        $this->selfie_path = $path;

        // OPTIONAL: store certificates if uploaded
        if ($this->certificate_path) {
            \Log::info('Storing certificate: ' . $this->certificate_path->getClientOriginalName());
            $path = $this->certificate_path->store('certificates', 'public');
            \Log::info('Stored certificate at: ' . $path);
            $validated['certificate_path'] = $path;
            $this->certificate_path = $path;
        }

        if ($this->marriage_certificate_path) {
            \Log::info('Storing marriage certificate: ' . $this->marriage_certificate_path->getClientOriginalName());
            $path = $this->marriage_certificate_path->store('certificates', 'public');
            \Log::info('Stored marriage certificate at: ' . $path);
            $validated['marriage_certificate_path'] = $path;
            $this->marriage_certificate_path = $path;
        }

        if ($this->birth_certificate_path) {
            \Log::info('Storing birth certificate: ' . $this->birth_certificate_path->getClientOriginalName());
            $path = $this->birth_certificate_path->store('certificates', 'public');
            \Log::info('Stored birth certificate at: ' . $path);
            $validated['birth_certificate_path'] = $path;
            $this->birth_certificate_path = $path;
        }

        if ($this->child_birth_certificate_path) {
            \Log::info('Storing child birth certificate: ' . $this->child_birth_certificate_path->getClientOriginalName());
            $path = $this->child_birth_certificate_path->store('certificates', 'public');
            \Log::info('Stored child birth certificate at: ' . $path);
            $validated['child_birth_certificate_path'] = $path;
            $this->child_birth_certificate_path = $path;
        }

        // Ensure availability is always an array
        if (!is_array($validated['availability'])) {
            $validated['availability'] = $validated['availability'] ? [$validated['availability']] : [];
        }

        CareBuddy::updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

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
