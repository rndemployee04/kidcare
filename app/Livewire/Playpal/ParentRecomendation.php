<?php

namespace App\Livewire\Playpal;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Parents;
use Carbon\Carbon;

/**
 * Livewire component for dynamic parent recommendations for PlayPals with pagination and filters.
 */
#[Layout('components.layouts.playpal')]
class ParentRecomendation extends Component
{
    use WithPagination;

    public $id;
    // Pagination and search
    public int $perPage = 8; // Show 8 parents per page
    public string $search = '';

    // Filtering options
    public ?string $location = null;
    public ?string $gender = 'any';
    public ?string $age_range = 'any';
    public ?string $number_of_children = 'any';
    public ?string $children_needing_care = 'any';
    public ?string $caregiver_type = 'any';
    public ?string $preferred_radius = 'any';
    public ?bool $special_needs_support = null;
    public $drop_off_time = [];

    // Persist search in query string
    protected $queryString = ['search'];

    public $showChildrenModal = false;
    public $selectedParent;
    public $children = [];

    /**
     * Clear all filters and search.
     */
    public function clearFilters()
    {
        $this->search = '';
        $this->location = null;
        $this->gender = 'any';
        $this->age_range = 'any';
        $this->number_of_children = 'any';
        $this->children_needing_care = 'any';
        $this->caregiver_type = 'any';
        $this->preferred_radius = 'any';
        $this->special_needs_support = null;
        $this->drop_off_time = [];
        $this->resetPage();
    }

    /**
     * Apply filters (for Apply Filters button)
     */
    public function applyFilters()
    {
        $this->resetPage();
    }

    public function viewChildren($parentId)
    {
        $this->selectedParent = Parents::with('children')->find($parentId);

        if ($this->selectedParent) {
            $this->children = $this->selectedParent->children;
            $this->showChildrenModal = true;
        }
    }

    public function closeChildrenModal()
    {
        $this->showChildrenModal = false;
        $this->selectedParent = null;
        $this->children = [];
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
     * Render the component with paginated and filtered parents.
     */
    public function render()
    {
        $user = auth()->user();
        $playpal = $user && $user->isPlayPal() ? $user->playPal : null;
        $bookedParentIds = [];
        if ($user && $user->isPlayPal() && $user->playPal) {
            $playpalProfileId = $user->playPal->id;
            $bookedParentIds = Booking::where('playpal_id', $playpalProfileId)
                ->where('status', '!=', 'rejected')
                ->where('status', '!=', 'completed')
                ->pluck('parent_id')->toArray();
        }

        $query = Parents::query();
        // Only show approved parents
        $query->whereHas('user', function ($q) {
            $q->where('verification_status', 'approved');
        });

        if ($playpal) {
            // Match caregiver type (PlayPal category to parent's preferred caregiver)
            $query->where(function ($q) use ($playpal) {
                $q->where('preferred_type_of_caregiver', 'like', "%{$playpal->category}%")
                    ->orWhere('preferred_type_of_caregiver','like','any')
                    ->orWhereNull('preferred_type_of_caregiver');
            });

            // Match radius (playpal provides service within parent's preferred radius)
            $query->where(function ($q) use ($playpal) {
                $q->whereNull('preferred_radius') // no preference
                    ->orWhere('preferred_radius', '<=', $playpal->service_radius);
            });
        }

        // Exclude already booked parents
        if (!empty($bookedParentIds)) {
            $query->whereNotIn('id', $bookedParentIds);
        }
        // Dynamic filters
        if ($this->location && $this->location !== '' && $this->location !== 'any') {
            $query->where('city', $this->location);
        }
        if ($this->gender && $this->gender !== 'any' && $this->gender !== '') {
            $query->where('gender', $this->gender);
        }
        if ($this->age_range && $this->age_range !== 'any' && $this->age_range !== '') {
            [$minAge, $maxAge] = explode('-', $this->age_range);
            $maxDob = Carbon::now()->subYears($minAge)->toDateString();
            $minDob = Carbon::now()->subYears($maxAge + 1)->toDateString();
            $query->whereBetween('dob', [$minDob, $maxDob]);
        }
        if ($this->number_of_children && $this->number_of_children !== 'any' && $this->number_of_children !== '') {
            $query->where('number_of_children', $this->number_of_children);
        }
        if ($this->children_needing_care && $this->children_needing_care !== 'any' && $this->children_needing_care !== '') {
            $query->where('number_needing_care', $this->children_needing_care);
        }
        if ($this->caregiver_type && $this->caregiver_type !== 'any' && $this->caregiver_type !== '') {
            $query->where('preferred_type_of_caregiver', $this->caregiver_type);
        }
        if ($this->preferred_radius && $this->preferred_radius !== 'any' && $this->preferred_radius !== '') {
            $query->where('preferred_radius', $this->preferred_radius);
        }
        if (!is_null($this->special_needs_support)) {
            $query->where('needs_special_needs_support', $this->special_needs_support);
        }
        if (is_array($this->drop_off_time) && count($this->drop_off_time) > 0) {
            foreach ($this->drop_off_time as $time) {
                $query->whereJsonContains('preferred_drop_off_time', $time);
            }
        }
        // Expanded search: name, city, profession
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('user', function ($q2) {
                    $q2->where('name', 'like', "%{$this->search}%");
                })
                    ->orWhere('city', 'like', "%{$this->search}%")
                    ->orWhere('profession', 'like', "%{$this->search}%");
            });
        }
        $parents = $query->with('user')->paginate($this->perPage);
        return view('livewire.playpal.parent-recomendation', compact('parents'));
    }
}