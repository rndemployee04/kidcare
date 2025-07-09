<?php

namespace App\Livewire\Parent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PlayPal;

/**
 * Livewire component for dynamic PlayPal recommendations with pagination and filters.
 */
#[Layout('components.layouts.parent')]
class PlaypalRecomendation extends Component
{
    use WithPagination;

    public $id;
    // Pagination and search
    public int $perPage = 8; // Show 8 PlayPals per page
    public string $search = '';

    // Filtering options (can be set from parent or UI)
    public ?string $location = null;
    public ?string $radius = null;
    public ?string $child_age = null;
    public ?string $category = 'any';
    public ?string $gender = 'any';
    public $insurance = null;
    public $availability = [];

    // Persist search in query string
    protected $queryString = ['search'];

    /**
     * Clear all filters and search.
     */
    public function clearFilters()
    {
        $this->search = '';
        $this->location = null;
        $this->radius = null;
        $this->child_age = null;
        $this->category = 'any';
        $this->gender = 'any';
        $this->insurance = null;
        $this->availability = [];
        $this->resetPage();
    }

    /**
     * Apply filters (for Apply Filters button)
     */
    public function applyFilters()
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when search is updated.
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * Mount the component. No defaults, no recommendation logic.
     */
    public function mount()
    {
        // Do nothing. All filters/search are blank by default.
    }

    /**
     * Render the component with paginated and filtered PlayPals.
     */
    public function render()
    {
        $user = auth()->user();
        $bookedPlaypalIds = [];
        if ($user && $user->isParent() && $user->parentProfile) {
            $parentProfileId = $user->parentProfile->id;
            $bookedPlaypalIds = \App\Models\Booking::where('parent_id', $parentProfileId)
                ->pluck('playpal_id')->toArray();
        }

        $query = PlayPal::query();
        // Only show approved PlayPals
        $query->whereHas('user', function ($q) {
            $q->where('verification_status', 'approved');
        });
        // Exclude already booked PlayPals
        if (!empty($bookedPlaypalIds)) {
            $query->whereNotIn('id', $bookedPlaypalIds);
        }
        // Dynamic filters
        if ($this->location && $this->location !== '' && $this->location !== 'any') {
            $query->where('city', $this->location);
        }
        if ($this->radius && $this->radius !== '' && $this->radius !== 'any') {
            $query->where('service_radius', $this->radius);
        }
        if ($this->child_age && $this->child_age !== '' && $this->child_age !== 'any') {
            $query->where('child_age_limit', 'like', "%{$this->child_age}%");
        }
        if (is_array($this->availability) && count($this->availability) > 0) {
            foreach ($this->availability as $avail) {
                $query->whereJsonContains('availability', $avail);
            }
        }
        if ($this->category && $this->category !== 'any' && $this->category !== '') {
            $query->where('category', $this->category);
        }
        if ($this->gender && $this->gender !== 'any' && $this->gender !== '') {
            $query->where('gender', $this->gender);
        }
        if (!is_null($this->insurance)) {
            $query->where('willing_to_take_insurance', (bool) $this->insurance);
        }
        // Expanded search: name, city, category, gender, child_age_limit
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('user', function ($q2) {
                    $q2->where('name', 'like', "%{$this->search}%");
                })
                    ->orWhere('city', 'like', "%{$this->search}%")
                    ->orWhere('category', 'like', "%{$this->search}%")
                    ->orWhere('gender', 'like', "%{$this->search}%")
                    ->orWhere('child_age_limit', 'like', "%{$this->search}%");
            });
        }
        $playpals = $query->with('user')->paginate($this->perPage);
        return view('livewire.parent.playpal-recomendation', compact('playpals'));
    }
}