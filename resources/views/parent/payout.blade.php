<x-parent.layouts.parent-layout>
    <div class="container mx-auto py-8">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Payout Summary</h2>
                <button class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded"
                    onclick="window.Livewire.dispatch('showBankDetailsModal')">Bank Details</button>
            </div>
            @livewire('parent.bank-details-manager')
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-blue-50 p-6 rounded-lg text-center">
                    <h3 class="text-lg font-semibold mb-2">Total Earnings</h3>
                    <p class="text-3xl font-bold">${{ number_format($totalEarnings, 2) }}</p>
                </div>
                
                <div class="bg-yellow-50 p-6 rounded-lg text-center">
                    <h3 class="text-lg font-semibold mb-2">Platform Fee (20%)</h3>
                    <p class="text-3xl font-bold text-yellow-600">-${{ number_format($platformFee, 2) }}</p>
                </div>
                <div class="bg-green-50 p-6 rounded-lg text-center">
                    <h3 class="text-lg font-semibold mb-2">Available to Transfer</h3>
                    <p class="text-3xl font-bold text-green-700">
                        ${{ $transferred ? number_format(0, 2) : number_format($transferable, 2) }}</p>
                </div>
            </div>
            
            @if(!$transferred && $transferable > 0 && $transferable >= $minimumAmountForPayout)
                <form method="POST" action="{{ route('parent.payout.transfer') }}">
                    @csrf
                    <input type="hidden" name="bank_details" value="{{ $bank_detail }}">
                    <input type="hidden" name="amount" value="{{ $transferable }}">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded">
                        Transfer to Bank
                    </button>
                </form>
            @elseif($transferred)
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded relative mt-4">
                    <span class="block sm:inline">Payout transferred to your bank account!</span>
                </div>
            @else
                <div class="bg-gray-100 border border-gray-300 text-gray-600 px-4 py-3 rounded relative mt-4">
                    <span class="block sm:inline"> ${{ $minimumAmountForPayout - $transferable }} more to be earned to transfer to your bank account.</span>
                </div>
            @endif
            <div class="mt-4">
                <h2 class="text-2xl font-bold mb-4">Payout History</h2>
                <table class="min-w-full divide-y divide-gray-200 border">
                    <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 border">
                    @foreach ($payouts as $payout)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 border">
                                <div class="text-sm leading-5">{{ $payout->created_at->format('d-M-Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 border">
                                <div class="text-sm leading-5">{{ $payout->amount }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 border">
                                <div class="text-sm leading-5">{{ $payout->status }}</div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-parent.layouts.parent-layout>