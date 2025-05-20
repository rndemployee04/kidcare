<?php

namespace App\Livewire\Parent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CareBuddy;

/**
 * Livewire component for dynamic carebuddy recommendations with pagination and filters.
 */
class CarebuddyRecommendations extends Component
{
    use WithPagination;
    public $id;
    // Pagination and search
    public int $perPage = 8; // Show 8 carebuddies per page
    public string $search = '';

    // Filtering options (can be set from parent or UI)
    public ?string $location = null;
    public ?string $radius = null;
    public ?string $child_age = null;
    public $availability = null; // array or string

    // Persist search in query string
    protected $queryString = ['search'];


    /**
     * Reset pagination when search is updated.
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * Render the component with paginated and filtered carebuddies.
     */
    public function render()
    {
        $query = CareBuddy::query();
        // Dynamic filters
        if ($this->location) {
            $query->where('city', $this->location);
        }
        if ($this->radius) {
            $query->where('service_radius', $this->radius);
        }
        if ($this->child_age) {
            $query->where('child_age_limit', 'like', "%{$this->child_age}%");
        }
        if ($this->availability) {
            $query->whereJsonContains('availability', $this->availability);
        }
        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', "%{$this->search}%");
            });
        }
        $carebuddies = $query->with('user')->paginate($this->perPage);
        return view('livewire.parent.carebuddy-recommendations', compact('carebuddies'));
    }
}
