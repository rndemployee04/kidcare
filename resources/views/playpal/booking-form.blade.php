<div>
    <h2>Book a Child</h2>
    <form wire:submit.prevent="submit">
        <label>Child</label>
        <select wire:model="child_id">
            <option value="">Select Child</option>
            @foreach ($children as $child)
                <option value="{{ $child->id }}">{{ $child->name }}</option>
            @endforeach
        </select>
        <label>Date</label>
        <input type="date" wire:model="date" required>
        <label>Time</label>
        <input type="time" wire:model="time" required>
        <label>Duration (days)</label>
        <input type="number" wire:model="duration_days" required min="1">
        <label>Amount</label>
        <input type="number" wire:model="amount" required min="0">
        <button type="submit">Send Booking Request</button>
    </form>
    @if (session()->has('success'))
        <div>{{ session('success') }}</div>
    @endif
</div>
