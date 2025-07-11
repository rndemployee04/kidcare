<?php
namespace App\Livewire\PlayPal;

use Livewire\Component;
use App\Models\User;
use App\Models\Child;

class Recommendations extends Component
{
    public $parents;

    public function mount()
    {
        $this->parents = User::where('role', 'parent')->with('children')->get();
    }

    public function render()
    {
        return view('playpal.recommendations', [
            'parents' => $this->parents,
        ]);
    }
}
