<x-parent.layouts.parent-layout>
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Welcome to your Dashboard</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Find carebuddies to help with your childcare needs.</p>
        </div>
        
        <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
            <h4 class="text-lg font-medium text-gray-900 mb-4">Recommended Carebuddies</h4>
            
            @livewire('parent.carebuddy-recommendations')
        </div>
    </div>
</x-parent.layouts.parent-layout>