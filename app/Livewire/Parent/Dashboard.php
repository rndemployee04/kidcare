<?php

namespace App\Livewire\Parent;

use App\Models\CareBuddy;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
class Dashboard extends Component
{
    use WithPagination;
    
    public $perPage = 6;
    public $hasMoreItems = false;
    
    public function mount()
    {
        if (!auth()->user() || !auth()->user()->isParent()) {
            return redirect()->route('home');
        }
    }
    
    public function loadMore()
    {
        $this->perPage += 6;
    }
    
    public function render()
    {
        $user = Auth::user();
        
        // Get carebuddy recommendations with pagination
        $carebuddies = CareBuddy::with(['user' => function($query) {
                $query->where('verification_status', 'approved');
            }])
            ->whereHas('user', function($query) {
                $query->where('verification_status', 'approved');
            })
            ->paginate($this->perPage);
            
        $this->hasMoreItems = $carebuddies->hasMorePages();
        
        return view('livewire.parent.dashboard', [
            'carebuddies' => $carebuddies,
            'user' => $user
        ]);
    }
}
