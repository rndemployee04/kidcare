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

        // 1. Get all carebuddy IDs already booked by this parent
        $bookedCarebuddyIds = [];
        if ($user->isParent() && $user->parentProfile) {
            $parentProfileId = $user->parentProfile->id;
            $bookedCarebuddyIds = \App\Models\Booking::where('parent_id', $parentProfileId)
                ->pluck('carebuddy_id')->toArray();
        }

        // 2. Only recommend carebuddies NOT already booked
        $carebuddies = CareBuddy::with(['user' => function($query) {
                $query->whereHas('user', function ($q) {
    $q->where('verification_status', 'approved');
});
            }])
            ->whereHas('user', function($query) {
                $query->whereHas('user', function ($q) {
    $q->where('verification_status', 'approved');
});
            })
            ->whereNotIn('id', $bookedCarebuddyIds)
            ->paginate($this->perPage);

        $this->hasMoreItems = $carebuddies->hasMorePages();

        return view('livewire.parent.dashboard', [
            'carebuddies' => $carebuddies,
            'user' => $user,
            'bookedCarebuddyIds' => $bookedCarebuddyIds
        ]);
    }
}
