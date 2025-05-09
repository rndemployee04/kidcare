<?php

use App\Http\Controllers\LandingPageController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Carebuddy\RegisterForm as CareBuddyRegisterForm;
use App\Livewire\Parent\RegisterForm as ParentRegisterForm;


Route::middleware(['auth', 'parent.registration.complete', 'parent.verified'])->group(function () {
    Route::get('dashboard', function () {
        if (!auth()->user()->isParent()) {
            abort(403);
        }
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'carebuddy.registration.complete', 'carebuddy.verified'])->group(function () {
    Route::get('/carebuddy/dashboard', function () {
        return view('carebuddy.dashboard');
    })->name('carebuddy.dashboard');
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

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('/carebuddy/register', CareBuddyRegisterForm::class)->name('carebuddy.register');
    Route::get('/parent/register', ParentRegisterForm::class)->name('parent.register');
});

Route::get('/', [LandingPageController::class, 'index'])->name('home');


require __DIR__ . '/auth.php';
