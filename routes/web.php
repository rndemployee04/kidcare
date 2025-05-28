<?php

use App\Http\Controllers\LandingPageController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Carebuddy\RegisterForm as CareBuddyRegisterForm;
use App\Livewire\Parent\RegisterForm as ParentRegisterForm;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Parent\Dashboard as ParentDashboard;
use App\Livewire\Carebuddy\Dashboard as CarebuddyDashboard;

// Parent dashboard and routes
Route::prefix('parent')->middleware(['auth', 'parent.verified'])->group(function () {
    Route::get('/dashboard', 'App\Http\Controllers\ParentController@dashboard')->name('parent.dashboard');
    Route::get('/profile', [\App\Http\Controllers\ParentProfileController::class, 'show'])->name('parent.profile.show');
    Route::put('/profile', [\App\Http\Controllers\ParentProfileController::class, 'update'])->name('parent.profile.update');
    Route::get('/activity', [\App\Http\Controllers\Parent\ActivityController::class, 'index'])->name('parent.activity');
});

// Carebuddy dashboard and routes
Route::prefix('carebuddy')->middleware(['auth', 'carebuddy.registration.complete', 'carebuddy.verified'])->group(function () {
    Route::get('/dashboard', 'App\Http\Controllers\CarebuddyController@dashboard')->name('carebuddy.dashboard');
    Route::get('/profile', [\App\Http\Controllers\CarebuddyProfileController::class, 'show'])->name('carebuddy.profile.show');
    Route::put('/profile', [\App\Http\Controllers\CarebuddyProfileController::class, 'update'])->name('carebuddy.profile.update');
    Route::get('/activity', [\App\Http\Controllers\Carebuddy\ActivityController::class, 'index'])->name('carebuddy.activity');
});

// Admin dashboard and routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'App\Http\Controllers\AdminController@dashboard')->name('admin.dashboard');
    Route::get('/approve/{id}', 'App\Http\Controllers\AdminController@approveUser')->name('admin.approve');
    Route::get('/reject/{id}', 'App\Http\Controllers\AdminController@rejectUser')->name('admin.reject');
    Route::get('/user/{id}/view', 'App\Http\Controllers\AdminController@viewApplication')->name('admin.viewApplication');
    // Add other admin-specific routes here
});

// Root route handler - redirects to appropriate dashboard based on role
Route::middleware(['auth', 'role.redirect'])->group(function () {
    Route::get('/dashboard', function () {
        // This route will be intercepted by the role.redirect middleware
        // and redirected to the appropriate dashboard based on role and verification status
        return redirect()->route('home');
    })->name('dashboard');
});

// Parent application status page
Route::get('/parent/application-status', function () {
    return view('parent.application-status');
})->name('parent.application.status');

// Carebuddy application status page
Route::get('/carebuddy/application-status', function () {
    return view('carebuddy.application-status');
})->name('carebuddy.application.status');

// Parent registration incomplete page
Route::get('/parent/registration-incomplete', function () {
    return view('parent.registration-incomplete');
})->name('parent.registration.incomplete');

// Carebuddy registration incomplete page
Route::get('/carebuddy/registration-incomplete', function () {
    return view('carebuddy.registration-incomplete');
})->name('carebuddy.registration.incomplete');

// Placeholder for parent resume registration
Route::get('/parent/resume-registration', function () {
    return view('parent.resume-registration');
})->name('parent.resume.registration');

// Placeholder for carebuddy resume registration
Route::get('/carebuddy/resume-registration', function () {
    return view('carebuddy.resume-registration');
})->name('carebuddy.resume.registration');

// MVP static routes for parent carebuddy recommendations and booking flow
use App\Models\CareBuddy;

Route::get('/parent/carebuddy/{id}', function ($id) {
    $carebuddy = CareBuddy::with('user')->find($id);
    if (!$carebuddy || !$carebuddy->user) {
        abort(404, 'Carebuddy not found');
    }
    $alreadyBooked = false;
    if (Auth::check() && Auth::user()->parent) {
        $alreadyBooked = Booking::where('carebuddy_id', $carebuddy->id)
            ->where('parent_id', Auth::user()->parent->id)
            ->exists();
    }
    // Gather all relevant fields
    $user = $carebuddy->user;
    return view('parent.carebuddy-profile', [
        'name' => $user->name ?? 'N/A',
        'email' => $user->email ?? 'N/A',
        'phone' => $carebuddy->phone ?? 'N/A',
        'gender' => $carebuddy->gender ?? 'N/A',
        'dob' => $carebuddy->dob ?? null,
        'current_address' => $carebuddy->current_address ?? 'N/A',
        'permanent_address' => $carebuddy->permanent_address ?? 'N/A',
        'city' => $carebuddy->city ?? 'N/A',
        'state' => $carebuddy->state ?? 'N/A',
        'zip' => $carebuddy->zip ?? 'N/A',
        'service_radius' => $carebuddy->service_radius ? $carebuddy->service_radius . ' km' : 'N/A',
        'child_age_limit' => $carebuddy->child_age_limit ?? 'N/A',
        'availability' => $carebuddy->availability ?? 'N/A',
        'id_proof_path' => $carebuddy->id_proof_path ?? null,
        'selfie_path' => $carebuddy->selfie_path ?? null,
        'willing_to_take_insurance' => $carebuddy->willing_to_take_insurance ?? null,
        'verification_status' => $carebuddy->verification_status ?? 'N/A',
        'bio' => $carebuddy->bio ?? '',
        'profile_photo' => $carebuddy->profile_photo ?? null,
        'carebuddy_id' => $carebuddy->id,
        'alreadyBooked' => $alreadyBooked,
        'user' => $user,
    ]);
})->name('parent.carebuddy.profile');

Route::get('/parent/book/{id}', function ($id) {
    // Show the payment form for booking
    $carebuddy = \App\Models\CareBuddy::with('user')->find($id);
    $amount = 500; // or fetch dynamic amount logic if needed
    return view('parent.payment', [
        'carebuddy_id' => $id,
        'carebuddy_name' => $carebuddy ? ($carebuddy->user->name ?? 'N/A') : 'N/A',
        'service_radius' => $carebuddy ? ($carebuddy->service_radius ?? 'N/A') : 'N/A',
        'amount' => $amount
    ]);
})->name('parent.book.slot');

// Parent booking POST route
use App\Http\Controllers\ParentBookingController;
use App\Http\Controllers\CarebuddyBookingController;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
Route::post('/parent/book/{id}', [ParentBookingController::class, 'store'])->name('parent.book.store');

// Parent and carebuddy bookings views
Route::get('/parent/my-bookings', [ParentBookingController::class, 'myBookings'])->name('parent.bookings');
Route::get('/carebuddy/my-bookings', [CarebuddyBookingController::class, 'myBookings'])->name('carebuddy.bookings');

// Carebuddy accept/reject booking
Route::post('/carebuddy/bookings/accept/{id}', [CarebuddyBookingController::class, 'accept'])->name('carebuddy.bookings.accept');
Route::post('/carebuddy/bookings/reject/{id}', [CarebuddyBookingController::class, 'reject'])->name('carebuddy.bookings.reject');

Route::match(['get', 'post'], '/parent/payment/success', function () {
    return view('parent.payment-success');
})->name('parent.payment.success');

// Public explore page for carebuddies
Route::get('/explore', [App\Http\Controllers\ExploreController::class, 'index'])->name('explore');
Route::get('/explore/{id}', [App\Http\Controllers\ExploreController::class, 'show'])->name('explore.show');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('/carebuddy/register', CareBuddyRegisterForm::class)->name('carebuddy.register');
    Route::get('/parent/register', ParentRegisterForm::class)->name('parent.register');
});

// Home page accessible by all users (both guests and authenticated users)
Route::get('/', [LandingPageController::class, 'index'])->name('home');

// Redirect route using the new role.redirect middleware
Route::get('/redirect', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'role.redirect'])->name('login.redirect');


// This duplicate admin dashboard route was removed - using the route defined earlier in the file

require __DIR__ . '/auth.php';
