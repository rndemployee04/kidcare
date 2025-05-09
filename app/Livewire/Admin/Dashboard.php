<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public $pendingUsers;
    public $approvedUsers;
    public $rejectedUsers;

    public function mount()
    {
        // Only allow admin
        if (!Auth::user() || !Auth::user()->isAdmin()) {
            abort(403);
        }
        $this->pendingUsers = User::where('role', '!=', 'admin')
            ->where('verification_status', 'pending')
            ->get();
        $this->approvedUsers = User::where('role', '!=', 'admin')
            ->where('verification_status', 'approved')
            ->get();
        $this->rejectedUsers = User::where('role', '!=', 'admin')
            ->where('verification_status', 'rejected')
            ->get();
    }

    public function approve($userId)
    {
        $user = User::findOrFail($userId);
        $user->verification_status = 'approved';
        $user->save();
        $this->mount();
        session()->flash('success', 'User approved successfully.');
    }

    public function reject($userId)
    {
        $user = User::findOrFail($userId);
        $user->verification_status = 'rejected';
        $user->save();
        $this->mount();
        session()->flash('error', 'User rejected.');
    }

    public function render()
    {
        return view('admin.dashboard');
    }
}
