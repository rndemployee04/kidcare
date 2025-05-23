<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

<x-layouts.onboarding class="min-h-screen bg-gradient-to-br from-blue-50 to-slate-100 flex items-center justify-center">
    <div class="max-w-lg w-full mx-auto bg-white/90 border border-gray-200 rounded-2xl shadow-xl p-10 text-center">
        <h1 class="text-3xl font-bold mb-8 text-blue-900 tracking-tight">Application Status</h1>
        @php $status = auth()->user()->verification_status; @endphp
        @if ($status === 'pending')
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-5 rounded-lg shadow flex items-start gap-4 mb-8">
                <i class="fas fa-hourglass-half text-yellow-500 text-3xl mt-1"></i>
                <div>
                    <h2 class="font-bold text-lg mb-1">Application Under Review</h2>
                    <p class="text-sm">Your application has been submitted and is currently under review.<br>You will be notified once it is verified.</p>
                </div>
            </div>
        @elseif ($status === 'rejected')
            <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-5 rounded-lg shadow flex items-start gap-4 mb-8">
                <i class="fas fa-times-circle text-red-500 text-3xl mt-1"></i>
                <div>
                    <h2 class="font-bold text-lg mb-1">Application Rejected</h2>
                    <p class="text-sm">Unfortunately, your application was rejected.<br>Please contact support for further assistance.</p>
                </div>
            </div>
        @elseif ($status === 'approved')
            <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-5 rounded-lg shadow flex items-start gap-4 mb-8">
                <i class="fas fa-check-circle text-green-500 text-3xl mt-1"></i>
                <div>
                    <h2 class="font-bold text-lg mb-1">Application Approved</h2>
                    <p class="text-sm">Congratulations! Your application has been approved. You can now access your dashboard and all features.</p>
                </div>
            </div>
            <a href="{{ route('carebuddy.dashboard') }}" class="w-full md:w-40 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-semibold shadow-sm transition text-center cursor-pointer flex items-center justify-center mb-4">
                <i class="fas fa-tachometer-alt mr-2"></i>Go to Dashboard
            </a>
        @endif

    </div>
</x-layouts.onboarding>
