<?php

namespace App\Livewire\Parent;

use App\Models\Child;
use Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ChildrenManager extends Component
{
    use WithFileUploads;

    public $children = [];

    public $child_id;
    public $full_name, $dob, $gender, $photo, $birth_certificate_path, $id_proof_path;
    public $has_insurance = false, $insurance_company, $insurance_terms;
    public $diseases, $disabilities, $allergies, $hobbies;
    public $editMode = false;
    public $editingChildId = null;
    public $limitReached = false;
    protected $rules = [
        'full_name' => 'required|string|max:255',
        'dob' => 'required|date',
        'gender' => 'required|in:male,female,other',
        'photo' => 'nullable|image|max:2048',
        'birth_certificate_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        'id_proof_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        'has_insurance' => 'boolean',
        'insurance_company' => 'nullable|string|max:255',
        'insurance_terms' => 'nullable|string',
        'diseases' => 'nullable|string',
        'disabilities' => 'nullable|string',
        'allergies' => 'nullable|string',
        'hobbies' => 'nullable|string',
    ];

    public function mount()
    {
        $this->loadChildren();
    }


    public function loadChildren()
    {
        $this->children = Child::where('parent_id', Auth::user()->parentProfile->id)->get();
        $this->checkLimit();
    }

    public function checkLimit()
    {
        $parent = Auth::user()->parentProfile;
        $this->limitReached = Child::where('parent_id', $parent->id)->count() >= $parent->number_needing_care;
    }
    public function save()
    {
        $parent = Auth::user()->parentProfile;
        $childCount = Child::where('parent_id', $parent->id)->count();

        if ($childCount >= $parent->number_needing_care) {
            session()->flash('error', 'You have already added all the children you need care for. Your care requirement is fulfilled.');
            return;
        }

        $this->validate();

        $child = new Child();
        $child->parent_id = Auth::user()->parentProfile->id;
        $child->fill($this->only([
            'full_name',
            'dob',
            'gender',
            'has_insurance',
            'insurance_company',
            'insurance_terms',
            'hobbies'
        ]));

        // File uploads
        if ($this->photo) {
            $child->photo = $this->photo->store('children/photos', 'public');
        }
        if ($this->birth_certificate_path) {
            $child->birth_certificate_path = $this->birth_certificate_path->store('children/certificates', 'public');
        }
        if ($this->id_proof_path) {
            $child->id_proof_path = $this->id_proof_path->store('children/id_proofs', 'public');
        }

        // Arrays
        $child->diseases = $this->explodeField($this->diseases);
        $child->disabilities = $this->explodeField($this->disabilities);
        $child->allergies = $this->explodeField($this->allergies);

        $child->save();

        $this->resetForm();
        $this->loadChildren();
        session()->flash('success', 'Child added successfully!');
    }

    public function delete($id)
    {
        $child = Child::findOrFail($id);
        $child->delete();
        $this->loadChildren();
        session()->flash('success', 'Child deleted successfully!');
    }

    private function explodeField($field)
    {
        return $field ? array_map('trim', explode(',', $field)) : [];
    }

    public function resetForm()
    {
        $this->reset([
            'full_name',
            'dob',
            'gender',
            'photo',
            'birth_certificate_path',
            'id_proof_path',
            'has_insurance',
            'insurance_company',
            'insurance_terms',
            'diseases',
            'disabilities',
            'allergies',
            'hobbies'
        ]);
    }





    // Populate form fields with selected child data
    public function edit($id)
    {
        $child = Child::findOrFail($id);

        $this->editingChildId = $child->id;
        $this->editMode = true;

        $this->full_name = $child->full_name;
        $this->dob = $child->dob->format('Y-m-d');
        $this->gender = $child->gender;
        $this->has_insurance = $child->has_insurance;
        $this->insurance_company = $child->insurance_company;
        $this->insurance_terms = $child->insurance_terms;
        $this->hobbies = $child->hobbies;

        $this->diseases = implode(', ', $child->diseases ?? []);
        $this->disabilities = implode(', ', $child->disabilities ?? []);
        $this->allergies = implode(', ', $child->allergies ?? []);
    }

    public function update()
    {
        $this->validate();

        $child = Child::findOrFail($this->editingChildId);

        $child->fill($this->only([
            'full_name',
            'dob',
            'gender',
            'has_insurance',
            'insurance_company',
            'insurance_terms',
            'hobbies',
        ]));

        // New files (optional)
        if ($this->photo) {
            $child->photo = $this->photo->store('children/photos', 'public');
        }
        if ($this->birth_certificate_path) {
            $child->birth_certificate_path = $this->birth_certificate_path->store('children/certificates', 'public');
        }
        if ($this->id_proof_path) {
            $child->id_proof_path = $this->id_proof_path->store('children/id_proofs', 'public');
        }

        // Arrays
        $child->diseases = $this->explodeField($this->diseases);
        $child->disabilities = $this->explodeField($this->disabilities);
        $child->allergies = $this->explodeField($this->allergies);

        $child->save();

        $this->resetForm();
        $this->editMode = false;
        $this->editingChildId = null;
        $this->loadChildren();
        session()->flash('success', 'Child updated successfully!');
    }
    public function render()
    {
        return view('livewire.parent.children-manager');
    }
}
