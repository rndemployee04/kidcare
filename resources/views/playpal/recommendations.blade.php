<div>
    <h2>Recommended Parents & Children</h2>
    <ul>
        @foreach ($parents as $parent)
            <li>
                <strong>{{ $parent->name }}</strong>
                <ul>
                    @foreach ($parent->children as $child)
                        <li>
                            {{ $child->name }} (Age: {{ $child->age }})
                            <a href="#" wire:click.prevent="$emit('startBooking', {{ $parent->id }}, {{ $child->id }})">Book</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</div>
