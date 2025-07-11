<div>
    <!-- Modal -->
    <div x-data="{ show: @entangle('showModal') }" x-show="show"
        class="fixed inset-0 flex items-center justify-center z-50 bg-transparent backdrop-blur-md bg-opacity-40"
        style="display: none;">
        <div class="bg-white rounded-lg p-6 w-full max-w-md" @click.away="show = false">
            <h4 class="text-lg font-bold mb-4">{{ $mode === 'add' ? 'Add' : 'Edit' }} Bank Account</h4>
            <form wire:submit.prevent="save">
                <div class="mb-2">
                    <label class="block">Account Holder</label>
                    <input type="text" wire:model.defer="account_holder" class="w-full border rounded px-2 py-1"
                        required />
                </div>
                <div class="mb-2">
                    <label class="block">Account Number</label>
                    <input type="text" wire:model.defer="account_number" class="w-full border rounded px-2 py-1"
                        required />
                </div>
                <div class="mb-2">
                    <label class="block">IFSC</label>
                    <input type="text" wire:model.defer="ifsc" class="w-full border rounded px-2 py-1" required />
                </div>
                <div class="mb-2">
                    <label class="block">Bank Name</label>
                    <input type="text" wire:model.defer="bank_name" class="w-full border rounded px-2 py-1" required />
                </div>

                <div class="flex justify-end">
                    <button type="button" @click="show = false"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-1 px-4 rounded mr-2">Cancel</button>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white py-1 px-4 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>