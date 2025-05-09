<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-slate-100 flex items-center justify-center">
    <div class="max-w-lg w-full bg-white/90 border border-gray-200 rounded-2xl shadow-xl p-10 text-center">
        @php $status = auth()->user()->verification_status; @endphp
        @if ($status === 'pending')
            <div class="flex flex-col items-center mb-6">
                <span class="text-5xl text-yellow-400 mb-2"><i class="fas fa-hourglass-half"></i></span>
                <h2 class="text-2xl font-extrabold mb-2 tracking-tight">Application Under Review</h2>
                <p class="mb-4 text-gray-700">Your application has been submitted and is currently under review.<br>You will be notified once it is verified.</p>
            </div>
        @elseif ($status === 'rejected')
            <div class="flex flex-col items-center mb-6">
                <span class="text-5xl text-red-500 mb-2"><i class="fas fa-times-circle"></i></span>
                <h2 class="text-2xl font-extrabold mb-2 text-red-600 tracking-tight">Application Rejected</h2>
                <p class="mb-4 text-gray-700">Unfortunately, your application was rejected.<br>Please contact support for further assistance.</p>
            </div>
        @endif
        <div class="flex flex-col items-center justify-center gap-4 mt-8 w-full">
            <div class="flex flex-col md:flex-row gap-4 w-full justify-center items-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-40 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md font-semibold shadow-sm transition cursor-pointer">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
                <a href="#" class="w-40 px-4 py-2 border border-blue-400 text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-md font-semibold shadow-sm transition text-center cursor-pointer flex items-center justify-center">
                    <i class="fas fa-file-contract mr-2"></i>Terms & Conditions
                </a>
            </div>
        </div>
    </div>
</div>
