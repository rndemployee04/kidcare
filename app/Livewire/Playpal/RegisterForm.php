<?php

namespace App\Livewire\Playpal;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PlayPal;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.onboarding')]
class RegisterForm extends Component
{
    use WithFileUploads;

    // PlayPal Info
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
        if (!Auth::user()?->isPlayPal()) {
            return redirect()->route('home');
        }
        // Load draft if exists
        $playpal = PlayPal::where('user_id', Auth::id())->first();
        if ($playpal) {
            foreach ($this->fillableFields() as $field) {
                if (isset($playpal->$field)) {
                    $this->$field = $playpal->$field;
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
        // Validate file inputs to ensure they meet requirements
        $this->validate([
            'profile_photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'id_proof_path' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'selfie_path' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'certificate_path' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'marriage_certificate_path' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'birth_certificate_path' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'child_birth_certificate_path' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        $data = $this->only($this->fillableFields());
        $data['user_id'] = Auth::id();

        // Store and log profile photo
        if ($this->profile_photo && !is_string($this->profile_photo)) {
            \Log::info('Storing profile photo: ' . $this->profile_photo->getClientOriginalName());
            $path = $this->profile_photo->store('profile_photos', 'public');
            \Log::info('Stored profile photo at: ' . $path);
            $data['profile_photo'] = $path;
            $this->profile_photo = $path;
        }

        // Store and log ID proof
        if ($this->id_proof_path && !is_string($this->id_proof_path)) {
            \Log::info('Storing ID proof: ' . $this->id_proof_path->getClientOriginalName());
            $path = $this->id_proof_path->store('id_proofs', 'public');
            \Log::info('Stored ID proof at: ' . $path);
            $data['id_proof_path'] = $path;
            $this->id_proof_path = $path;
        }

        // Store and log selfie
        if ($this->selfie_path && !is_string($this->selfie_path)) {
            \Log::info('Storing selfie: ' . $this->selfie_path->getClientOriginalName());
            $path = $this->selfie_path->store('selfies', 'public');
            \Log::info('Stored selfie at: ' . $path);
            $data['selfie_path'] = $path;
            $this->selfie_path = $path;
        }

        // OPTIONAL: store certificates if uploaded
        if ($this->certificate_path && !is_string($this->certificate_path)) {
            \Log::info('Storing certificate: ' . $this->certificate_path->getClientOriginalName());
            $path = $this->certificate_path->store('certificates', 'public');
            \Log::info('Stored certificate at: ' . $path);
            $data['certificate_path'] = $path;
            $this->certificate_path = $path;
        }

        if ($this->marriage_certificate_path && !is_string($this->marriage_certificate_path)) {
            \Log::info('Storing marriage certificate: ' . $this->marriage_certificate_path->getClientOriginalName());
            $path = $this->marriage_certificate_path->store('certificates', 'public');
            \Log::info('Stored marriage certificate at: ' . $path);
            $data['marriage_certificate_path'] = $path;
            $this->marriage_certificate_path = $path;
        }

        if ($this->birth_certificate_path && !is_string($this->birth_certificate_path)) {
            \Log::info('Storing birth certificate: ' . $this->birth_certificate_path->getClientOriginalName());
            $path = $this->birth_certificate_path->store('certificates', 'public');
            \Log::info('Stored birth certificate at: ' . $path);
            $data['birth_certificate_path'] = $path;
            $this->birth_certificate_path = $path;
        }

        if ($this->child_birth_certificate_path && !is_string($this->child_birth_certificate_path)) {
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

        PlayPal::updateOrCreate(
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
            'phone' => 'required|string|max_digits:13',
            'gender' => 'required|in:male,female,others',
            'profile_photo' => [
                function ($attribute, $value, $fail) {
                    if (!$value) {
                        $fail('Profile photo is required.');
                    } elseif (is_string($value)) {
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
                    } elseif (!in_array($value->getClientOriginalExtension(), ['pdf', 'jpg', 'jpeg','png','webp'])) {
                        $fail('ID proof must be a PDF, JPG, or JPEG file.');
                    } elseif ($value->getSize() > 2048 * 1024) {
                        $fail('ID proof must not exceed 2MB.');
                    }
                },
            ],
            'selfie_path' => [
                function ($attribute, $value, $fail) {
                    if (!$value) {
                        $fail('Selfie is required.');
                    } elseif (is_string($value)) {
                        return;
                    } elseif (!in_array($value->getClientOriginalExtension(), ['jpg', 'jpeg','png','webp'])) {
                        $fail('Selfie must be a JPG or JPEG file.');
                    } elseif ($value->getSize() > 2048 * 1024) {
                        $fail('Selfie must not exceed 2MB.');
                    }
                },
            ],
            'marriage_certificate_path' => function ($attribute, $value, $fail) {
                if ($this->category === 'newlywed' || $this->category === 'parent') {
                    if (!$value) {
                        $fail('Marriage certificate is required for newlywed and parent categories.');
                    } elseif (is_string($value)) {
                        return;
                    } elseif (!in_array($value->getClientOriginalExtension(), ['pdf', 'jpg', 'jpeg'])) {
                        $fail('Marriage certificate must be a PDF, JPG, or JPEG file.');
                    } elseif ($value->getSize() > 2048 * 1024) {
                        $fail('Marriage certificate must not exceed 2MB.');
                    }
                }
            },
            'certificate_path' => function ($attribute, $value, $fail) {
                if ($this->category === 'professional') {
                    if (!$value) {
                        $fail('Professional certificate is required for professional category.');
                    } elseif (is_string($value)) {
                        return;
                    } elseif (!in_array($value->getClientOriginalExtension(), ['pdf', 'jpg', 'jpeg'])) {
                        $fail('Professional certificate must be a PDF, JPG, or JPEG file.');
                    } elseif ($value->getSize() > 2048 * 1024) {
                        $fail('Professional certificate must not exceed 2MB.');
                    }
                }
            },
            'birth_certificate_path' => function ($attribute, $value, $fail) {
                if ($this->category === 'senior') {
                    if (!$value) {
                        $fail('Birth certificate is required for senior category.');
                    } elseif (is_string($value)) {
                        return;
                    } elseif (!in_array($value->getClientOriginalExtension(), ['pdf', 'jpg', 'jpeg'])) {
                        $fail('Birth certificate must be a PDF, JPG, or JPEG file.');
                    } elseif ($value->getSize() > 2048 * 1024) {
                        $fail('Birth certificate must not exceed 2MB.');
                    }
                }
            },
            'child_birth_certificate_path' => function ($attribute, $value, $fail) {
                if ($this->category === 'parent') {
                    if (!$value) {
                        $fail('Child birth certificate is required for parent category.');
                    } elseif (is_string($value)) {
                        return;
                    } elseif (!in_array($value->getClientOriginalExtension(), ['pdf', 'jpg', 'jpeg'])) {
                        $fail('Child birth certificate must be a PDF, JPG, or JPEG file.');
                    } elseif ($value->getSize() > 2048 * 1024) {
                        $fail('Child birth certificate must not exceed 2MB.');
                    }
                }
            },
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

        // Store files only if they are UploadedFile instances
        if ($this->profile_photo && !is_string($this->profile_photo)) {
            \Log::info('Storing profile photo: ' . $this->profile_photo->getClientOriginalName());
            $path = $this->profile_photo->store('profile_photos', 'public');
            \Log::info('Stored profile photo at: ' . $path);
            $validated['profile_photo'] = $path;
        } else {
            $validated['profile_photo'] = $this->profile_photo;
        }

        if ($this->id_proof_path && !is_string($this->id_proof_path)) {
            \Log::info('Storing ID proof: ' . $this->id_proof_path->getClientOriginalName());
            $path = $this->id_proof_path->store('id_proofs', 'public');
            \Log::info('Stored ID proof at: ' . $path);
            $validated['id_proof_path'] = $path;
        } else {
            $validated['id_proof_path'] = $this->id_proof_path;
        }

        if ($this->selfie_path && !is_string($this->selfie_path)) {
            \Log::info('Storing selfie: ' . $this->selfie_path->getClientOriginalName());
            $path = $this->selfie_path->store('selfies', 'public');
            \Log::info('Stored selfie at: ' . $path);
            $validated['selfie_path'] = $path;
        } else {
            $validated['selfie_path'] = $this->selfie_path;
        }

        if ($this->certificate_path && !is_string($this->certificate_path)) {
            \Log::info('Storing certificate: ' . $this->certificate_path->getClientOriginalName());
            $path = $this->certificate_path->store('certificates', 'public');
            \Log::info('Stored certificate at: ' . $path);
            $validated['certificate_path'] = $path;
        } else {
            $validated['certificate_path'] = $this->certificate_path;
        }

        if ($this->marriage_certificate_path && !is_string($this->marriage_certificate_path)) {
            \Log::info('Storing marriage certificate: ' . $this->marriage_certificate_path->getClientOriginalName());
            $path = $this->marriage_certificate_path->store('certificates', 'public');
            \Log::info('Stored marriage certificate at: ' . $path);
            $validated['marriage_certificate_path'] = $path;
        } else {
            $validated['marriage_certificate_path'] = $this->marriage_certificate_path;
        }

        if ($this->birth_certificate_path && !is_string($this->birth_certificate_path)) {
            \Log::info('Storing birth certificate: ' . $this->birth_certificate_path->getClientOriginalName());
            $path = $this->birth_certificate_path->store('certificates', 'public');
            \Log::info('Stored birth certificate at: ' . $path);
            $validated['birth_certificate_path'] = $path;
        } else {
            $validated['birth_certificate_path'] = $this->birth_certificate_path;
        }

        if ($this->child_birth_certificate_path && !is_string($this->child_birth_certificate_path)) {
            \Log::info('Storing child birth certificate: ' . $this->child_birth_certificate_path->getClientOriginalName());
            $path = $this->child_birth_certificate_path->store('certificates', 'public');
            \Log::info('Stored child birth certificate at: ' . $path);
            $validated['child_birth_certificate_path'] = $path;
        } else {
            $validated['child_birth_certificate_path'] = $this->child_birth_certificate_path;
        }

        // Ensure availability is always an array
        if (!is_array($validated['availability'])) {
            $validated['availability'] = $validated['availability'] ? [$validated['availability']] : [];
        }

        PlayPal::updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        $user = Auth::user();
        $user->registration_complete = true;
        $user->save();

        session()->flash('success', 'PlayPal registration saved!');
        return redirect()->route('playpal.dashboard');
    }

    public function render()
    {
        return view('playpal.register-form');
    }
}