<?php

use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ParentController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Models\Parents;
use Illuminate\Support\Facades\Route;
use App\Livewire\Carebuddy\RegisterForm as CareBuddyRegisterForm;
use App\Livewire\Parent\RegisterForm as ParentRegisterForm;
use App\Livewire\PlayPal\RegisterForm as PlayPalRegisterForm;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Parent\Dashboard as ParentDashboard;
use App\Livewire\Carebuddy\Dashboard as CarebuddyDashboard;
use Illuminate\Http\Request;
use App\Http\Controllers\PlayPalBookingController;

// Parent dashboard and routes
Route::prefix('parent')->name('parent.')->middleware(['auth', 'parent.verified'])->group(function () {
    Route::get('/dashboard', 'App\Http\Controllers\ParentController@dashboard')->name('dashboard');
    Route::get('/profile', [\App\Http\Controllers\ParentProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [\App\Http\Controllers\ParentProfileController::class, 'update'])->name('profile.update');
    Route::get('/activity', [\App\Http\Controllers\Parent\ActivityController::class, 'index'])->name('activity');
    Route::get('/bookings', 'App\Http\Controllers\ParentBookingController@index')->name('bookings');
    Route::get('/booking/{id}', 'App\Http\Controllers\ParentBookingController@show')->name('booking.show');
    Route::get('/children', [ChildrenController::class, 'index'])->name('children.index');
});

// Carebuddy dashboard and routes
Route::prefix('carebuddy')->middleware(['auth', 'carebuddy.registration.complete', 'carebuddy.verified'])->group(function () {
    Route::get('/dashboard', 'App\Http\Controllers\CarebuddyController@dashboard')->name('carebuddy.dashboard');
    Route::get('/profile', [\App\Http\Controllers\CarebuddyProfileController::class, 'show'])->name('carebuddy.profile.show');
    Route::put('/profile', [\App\Http\Controllers\CarebuddyProfileController::class, 'update'])->name('carebuddy.profile.update');
    Route::get('/activity', [\App\Http\Controllers\Carebuddy\ActivityController::class, 'index'])->name('carebuddy.activity');
    Route::get('/bookings', 'App\Http\Controllers\CarebuddyBookingController@index')->name('carebuddy.bookings');
    Route::get('/booking/{id}', 'App\Http\Controllers\CarebuddyBookingController@show')->name('carebuddy.booking.show');

});

Route::prefix('playpal')->middleware(['auth', 'playpal.registration.complete', 'playpal.verified'])->group(function () {
    Route::get('/dashboard', 'App\Http\Controllers\PlayPalController@dashboard')->name('playpal.dashboard');
    Route::get('/profile', [\App\Http\Controllers\PlayPalProfileController::class, 'show'])->name('playpal.profile.show');
    Route::put('/profile', [\App\Http\Controllers\PlayPalProfileController::class, 'update'])->name('playpal.profile.update');
    Route::get('/activity', [\App\Http\Controllers\PlayPal\ActivityController::class, 'index'])->name('playpal.activity');
    Route::get('/booking/{id}', [PlayPalBookingController::class, 'show'])->name('playpal.booking.show');
});

// Admin dashboard and routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'App\Http\Controllers\AdminController@dashboard')->name('admin.dashboard');
    Route::get('/approve/{id}', 'App\Http\Controllers\AdminController@approveUser')->name('admin.approve');
    Route::get('/reject/{id}', 'App\Http\Controllers\AdminController@rejectUser')->name('admin.reject');
    Route::get('/user/{id}/view', 'App\Http\Controllers\AdminController@viewApplication')->name('admin.viewApplication');
    // Add other admin-specific routes here    
});

// Booking routes

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

// PlayPal application status page
Route::get('/playpal/application-status', function () {
    return view('playpal.application-status');
})->name('playpal.application.status');

// Parent registration incomplete page
Route::get('/parent/registration-incomplete', function () {
    return view('parent.registration-incomplete');
})->name('parent.registration.incomplete');

// Carebuddy registration incomplete page
Route::get('/carebuddy/registration-incomplete', function () {
    return view('carebuddy.registration-incomplete');
})->name('carebuddy.registration.incomplete');

// PlayPal registration incomplete page
Route::get('/playpal/registration-incomplete', function () {
    return view('playpal.registration-incomplete');
})->name('playpal.registration.incomplete');

// Placeholder for parent resume registration
Route::get('/parent/resume-registration', function () {
    return view('parent.resume-registration');
})->name('parent.resume.registration');

// Placeholder for carebuddy resume registration
Route::get('/carebuddy/resume-registration', function () {
    return view('carebuddy.resume-registration');
})->name('carebuddy.resume.registration');

// Placeholder for playpal resume registration
Route::get('/playpal/resume-registration', function () {
    return view('playpal.resume-registration');
})->name('playpal.resume.registration');

// MVP static routes for parent carebuddy recommendations and booking flow
use App\Models\CareBuddy;
use App\Models\PlayPal;

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

Route::get('/playpal/parent/{id}', function ($id) {
    $parent = Parents::with('user')->find($id);
    if (!$parent || !$parent->user) {
        abort(404, 'Parent not found');
    }
    $alreadyBooked = false;
    if (Auth::check() && Auth::user()->parent) {
        $alreadyBooked = Booking::where('parent_id', $parent->id)
            ->where('parent_id', Auth::user()->parent->id)
            ->exists();
    }
    // Gather all relevant fields
    $user = $parent->user;
    return view('playpal.parent-profile', [
        'name' => $user->name ?? 'N/A',
        'email' => $user->email ?? 'N/A',
        'phone' => $parent->phone ?? 'N/A',
        'gender' => $parent->gender ?? 'N/A',
        'dob' => $parent->dob ?? null,
        'current_address' => $parent->current_address ?? 'N/A',
        'permanent_address' => $parent->permanent_address ?? 'N/A',
        'city' => $parent->city ?? 'N/A',
        'state' => $parent->state ?? 'N/A',
        'zip' => $parent->zip ?? 'N/A',
        'service_radius' => $parent->service_radius ? $parent->service_radius . ' km' : 'N/A',
        'child_age_limit' => $parent->child_age_limit ?? 'N/A',
        'availability' => $parent->availability ?? 'N/A',
        'id_proof_path' => $parent->id_proof_path ?? null,
        'selfie_path' => $parent->selfie_path ?? null,
        'willing_to_take_insurance' => $parent->willing_to_take_insurance ?? null,
        'verification_status' => $parent->verification_status ?? 'N/A',
        'bio' => $parent->bio ?? '',
        'profile_photo' => $parent->profile_photo ?? null,
        'parent_id' => $parent->id,
        'alreadyBooked' => $alreadyBooked,
        'user' => $user,
        'children' => $parent->children,
    ]);
})->name('parent.playpal.profile');

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

Route::get('/playpal/book/{id}', function ($id) {
    // Show the payment form for booking
    $parent = \App\Models\Parents::with('user')->find($id);
    $amount = 500; // or fetch dynamic amount logic if needed
    return view('playpal.payment', [
        'parent' => $parent,
        'parent_id' => $id,
        'parent_name' => $parent ? ($parent->user->name ?? 'N/A') : 'N/A',
        'service_radius' => $parent ? ($parent->preferred_radius ?? 'N/A') : 'N/A',
        'amount' => $amount
    ]);
})->name('parent.book.slot');

// Parent booking POST route
use App\Http\Controllers\ParentBookingController;
use App\Http\Controllers\CarebuddyBookingController;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

Route::post('/parent/book/{id}', [ParentBookingController::class, 'store'])->name('parent.book.store');
Route::post('/playpal/book/{id}', [PlayPalBookingController::class, 'store'])->name('playpal.book.store');

// Parent and carebuddy bookings views
Route::get('/parent/my-bookings', [ParentBookingController::class, 'myBookings'])->name('parent.bookings');
Route::get('/carebuddy/my-bookings', [CarebuddyBookingController::class, 'myBookings'])->name('carebuddy.bookings');
Route::get('/playpal/my-bookings', [PlayPalBookingController::class, 'myBookings'])->name('playpal.bookings');

// Carebuddy accept/reject booking
Route::post('/carebuddy/bookings/accept/{id}', [CarebuddyBookingController::class, 'accept'])->name('carebuddy.bookings.accept');
Route::post('/carebuddy/bookings/reject/{id}', [CarebuddyBookingController::class, 'reject'])->name('carebuddy.bookings.reject');

// Parent accept/reject booking
Route::post('/parent/bookings/accept/{id}', [ParentBookingController::class, 'accept'])->name('parent.bookings.accept');
Route::post('/parent/bookings/reject/{id}', [ParentBookingController::class, 'reject'])->name('parent.bookings.reject');
Route::delete('/parent/bookings/destroy/{id}', [ParentBookingController::class, 'destroy'])->name('parent.bookings.destroy');

Route::match(['get', 'post'], '/parent/payment/success', function () {
    return view('parent.payment-success');
})->name('parent.payment.success');

Route::match(['get', 'post'], '/playpal/payment/success', function () {
    return view('playpal.payment-success');
})->name('playpal.payment.success');

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
    Route::get('/playpal/register', PlayPalRegisterForm::class)->name('playpal.register');

});

// Home page accessible by all users (both guests and authenticated users)
Route::get('/', [LandingPageController::class, 'index'])->name('home');

// Redirect route using the new role.redirect middleware
Route::get('/redirect', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'role.redirect'])->name('login.redirect');



Route::post('/dismiss-alert', function (Request $request) {
    $key = $request->input('key');
    if ($key) {
        session()->put($key, true); // Mark it as dismissed
    }
    return response()->json(['status' => 'dismissed']);
})->name('dismiss.alert');
// This duplicate admin dashboard route was removed - using the route defined earlier in the file

require __DIR__ . '/auth.php';
