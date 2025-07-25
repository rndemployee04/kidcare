<?php

namespace App\Livewire\Parent;

use Livewire\Component;

use App\Models\ParentBankAccount;
use Illuminate\Support\Facades\Auth;

class BankDetailsManager extends Component
{
    public $accounts = [];
    public $showModal = false;
    public $mode = 'add'; // or 'edit'
    public $account_holder, $account_number, $ifsc, $bank_name, $is_default = false, $editing_id = null;

    protected $listeners = ['showBankDetailsModal' => 'openModal'];

    public function mount()
    {
        $this->loadAccounts();
    }

    public function loadAccounts()
    {
        $parent = Auth::user()->parentProfile;
        $this->accounts = $parent->bankAccounts()->get()->toArray();
    }

    public function openModal()
    {
        $parent = Auth::user()->parentProfile;
        $account = $parent->bankAccounts()->first();
        if ($account) {
            $this->editing_id = $account->id;
            $this->account_holder = $account->account_holder;
            $this->account_number = $account->account_number;
            $this->ifsc = $account->ifsc;
            $this->bank_name = $account->bank_name;
            $this->is_default = $account->is_default;
            $this->mode = 'edit';
        } else {
            $this->resetForm();
            $this->mode = 'add';
        }
        $this->showModal = true;
    }

    public function showEditModal($id)
    {
        $account = ParentBankAccount::findOrFail($id);
        $this->editing_id = $account->id;
        $this->account_holder = $account->account_holder;
        $this->account_number = $account->account_number;
        $this->ifsc = $account->ifsc;
        $this->bank_name = $account->bank_name;
        $this->is_default = $account->is_default;
        $this->mode = 'edit';
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'account_holder' => 'required|string|max:255',
            'account_number' => 'required|string|max:32',
            'ifsc' => 'required|string|max:20',
            'bank_name' => 'required|string|max:255',
        ]);
        $parent = Auth::user()->parentProfile;
        $account = $parent->bankAccounts()->first();
        if ($account) {
            // Update existing
            $account->update([
                'account_holder' => $this->account_holder,
                'account_number' => $this->account_number,
                'ifsc' => $this->ifsc,
                'bank_name' => $this->bank_name,
                'is_default' => $this->is_default,
            ]);
        } else {
            // Create new
            $account = ParentBankAccount::create([
                'parent_id' => $parent->id,
                'account_holder' => $this->account_holder,
                'account_number' => $this->account_number,
                'ifsc' => $this->ifsc,
                'bank_name' => $this->bank_name,
                'is_default' => $this->is_default,
            ]);
        }
        // If set as default, unset others
        if ($this->is_default) {
            ParentBankAccount::where('parent_id', $parent->id)
                ->where('id', '!=', $account->id)
                ->update(['is_default' => false]);
        }
        $this->showModal = false;
        $this->resetForm();
        $this->loadAccounts();
        $this->dispatch('bank-details-saved');
    }

    public function delete($id)
    {
        $parent = Auth::user()->parentProfile;
        $acc = ParentBankAccount::where('parent_id', $parent->id)->findOrFail($id);
        $acc->delete();
        $this->loadAccounts();
    }

    public function setDefault($id)
    {
        $parent = Auth::user()->parentProfile;
        ParentBankAccount::where('parent_id', $parent->id)->update(['is_default' => false]);
        $acc = ParentBankAccount::where('parent_id', $parent->id)->findOrFail($id);
        $acc->is_default = true;
        $acc->save();
        $this->loadAccounts();
    }

    public function resetForm()
    {
        $this->account_holder = '';
        $this->account_number = '';
        $this->ifsc = '';
        $this->bank_name = '';
        $this->is_default = false;
        $this->editing_id = null;
        $this->mode = 'add';
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.parent.bank-details-manager');
    }
}
