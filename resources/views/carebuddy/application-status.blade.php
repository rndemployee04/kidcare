<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

<x-layouts.onboarding class="min-h-screen bg-gradient-to-br from-blue-50 to-slate-100 flex items-center justify-center">
    <div
        class=" dfdsf max-w-lg w-full mx-auto bg-white/90 border border-gray-200 rounded-2xl shadow-xl p-10 text-center md:absolute left-0 right-0 top-[30%]">
        <h1 class="text-3xl font-bold mb-8 text-blue-900 tracking-tight">Application Status</h1>
        @php $status = auth()->user()->verification_status; @endphp
        @if ($status === 'pending')
            <div
                class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-5 rounded-lg shadow flex items-start gap-4 mb-8">
                <i class="fas fa-hourglass-half text-orange-500 text-3xl mt-1"></i>
                <div>
                    <h2 class="font-bold text-lg mb-1">Application Under Review</h2>
                    <p class="text-sm">Your application has been submitted and is currently under review.<br>You will be
                        notified once it is verified.</p>
                </div>
            </div>
        @elseif ($status === 'rejected')
            <div
                class="bg-red-100 border-l-4 border-red-500 text-red-800 p-5 rounded-lg shadow flex items-start gap-4 mb-8">
                <i class="fas fa-times-circle text-red-500 text-3xl mt-1"></i>
                <div>
                    <h2 class="font-bold text-lg mb-1">Application Rejected</h2>
                    <p class="text-sm">Unfortunately, your application was rejected.<br>Please contact support for further
                        assistance.</p>
                </div>
            </div>
        @elseif ($status === 'approved')
            <div
                class="bg-orange-100 border-l-4 border-orange-500 text-orange-800 p-5 rounded-lg shadow flex items-start gap-4 mb-8">
                <i class="fas fa-check-circle text-green-500 text-3xl mt-1"></i>
                <div>
                    <h2 class="font-bold text-lg mb-1">Application Approved</h2>
                    <p class="text-sm">Congratulations! Your application has been approved. You can now access your
                        dashboard and all features.</p>
                </div>
            </div>
            <a href="{{ route('carebuddy.dashboard') }}"
                class="!w-full md:w-40 px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-md font-semibold shadow-sm transition text-center cursor-pointer flex items-center justify-center mb-4">
                <i class="fas fa-tachometer-alt mr-2"></i>Go to Dashboard
            </a>
        @endif
        <div class="flex flex-col md:flex-row gap-4 w-full max-w-md mx-auto justify-center items-center">
            <form method="POST" action="{{ route('logout') }}" class="w-full md:w-auto">
                @csrf
                <button type="submit"
                    class="w-full md:w-auto px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md font-semibold shadow-sm transition cursor-pointer flex items-center justify-center">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </button>
            </form>
            <a href="{{ route('home') }}"
                class="w-full md:w-auto px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-md font-semibold shadow-sm transition text-center cursor-pointer flex items-center justify-center">
                <i class="fas fa-home mr-2"></i>Go to Home
            </a>
        </div>

    </div>
</x-layouts.onboarding>