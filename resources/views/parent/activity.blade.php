<x-parent.layouts.parent-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Activity Log
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    A record of your recent activities on the platform.
                </p>
            </div>
            <div class="bg-white shadow overflow-hidden sm:rounded-b-lg">
                <ul class="divide-y divide-gray-200">
                    @forelse ($activities as $activity)
                        <li class="px-6 py-4 hover:bg-gray-50">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                    @php
                                        $icon = match($activity->description) {
                                            'created' => 'M12 6v6m0 0v6m0-6h6m-6 0H6',
                                            'updated' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
                                            'deleted' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
                                            default => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'
                                        };
                                    @endphp
                                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ ucfirst($activity->description) }}
                                        @if($activity->subject_type)
                                            <span class="text-gray-500">
                                                {{ class_basename($activity->subject_type) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $activity->created_at->diffForHumans() }}
                                    </div>
                                    @if(!empty($activity->properties))
                                        <div class="mt-1 text-sm text-gray-500">
                                            @foreach($activity->properties as $key => $value)
                                                @if(!in_array($key, ['attributes', 'old']))
                                                    <div>
                                                        <span class="font-medium">{{ $key }}:</span>
                                                        <span class="ml-1">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="px-6 py-4 text-center text-gray-500">
                            No activities found.
                        </li>
                    @endforelse
                </ul>
                @if($activities->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $activities->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-parent.layouts.parent-layout>
