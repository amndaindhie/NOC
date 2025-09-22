<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

use App\Livewire\Admin\Dashboard;
use App\Http\Controllers\Admin\NocAdminController;
use App\Http\Controllers\Admin\NocCrudController;
use App\Http\Controllers\NocFormController;
use App\Http\Controllers\BackupController;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\TicketTrackingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman awal
Route::view('/', 'frontend.index')->name('home');

// Frontend pages
Route::view('/about', 'frontend.about')->name('frontend.about');
Route::view('/contact', 'frontend.contact')->name('frontend.contact');
Route::view('/showpdf', 'frontend.showpdf')->name('frontend.showpdf');
Route::get('/tracking-request', [App\Http\Controllers\Frontend\TicketTrackingFrontendController::class, 'index'])->name('frontend.tracking');

// ================== AUTH ROUTES ==================
Route::get('/login', function () {
    return redirect()->route('home');
})->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

use App\Livewire\Admin\Dashboard as AdminDashboard;

// Dashboard umum
Route::get('/dashboard', function () {
    return view('user-dashboard');
})->middleware(['auth'])->name('dashboard');

// Admin dashboard route
Route::get('/admin/dashboard', AdminDashboard::class)
    ->middleware(['auth', 'App\Http\Middleware\RedirectByRole'])
    ->name('admin.dashboard');

use App\Http\Controllers\Frontend\ProfileController;

// Profile
Route::get('/profile', [ProfileController::class, 'show'])
    ->middleware(['auth'])
    ->name('profile');

// ================== OTP VERIFICATION ==================
Route::middleware('guest')->group(function () {
    Route::get('/verify-email-otp', [EmailVerificationController::class, 'showVerificationForm'])
        ->name('verification.otp.form');
    Route::post('/verify-email-otp', [EmailVerificationController::class, 'verify'])
        ->middleware(['throttle:5,1', 'App\Http\Middleware\RateLimitOtp'])
        ->name('verification.otp.verify');
    Route::post('/resend-otp', [EmailVerificationController::class, 'resend'])
        ->middleware(['throttle:3,1', 'App\Http\Middleware\RateLimitOtp'])
        ->name('verification.otp.resend');

    // New route for OTP verification page
    Route::get('/otp-verification', function () {
        $email = request('email');
        return view('frontend.otp_verification_page', ['email' => $email]);
    })->name('verification.otp.page');
});

 // ================== ADMIN ROUTES ==================
Route::middleware(['auth', 'App\Http\Middleware\RedirectByRole'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/tenant-dashboard', \App\Livewire\Admin\TenantDashboard::class)->name('tenant-dashboard');

    // User Management
    Route::get('/users', \App\Livewire\Admin\UserManagement::class)
        ->name('users');

        // ---------- NOC MANAGEMENT ----------
        Route::prefix('noc')->name('noc.')->group(function () {
            // Instalasi
            Route::get('/instalasi', [NocAdminController::class, 'instalasi'])->name('instalasi');
            Route::get('/instalasi/create', [NocCrudController::class, 'createInstallation'])->name('instalasi.create');
            Route::post('/instalasi/store', [NocCrudController::class, 'storeInstallation'])->name('instalasi.store');
            Route::get('/instalasi/{id}', [NocCrudController::class, 'showInstallation'])->name('instalasi.show');
            Route::get('/instalasi/{id}/edit', [NocCrudController::class, 'editInstallation'])->name('instalasi.edit');
            Route::post('/instalasi/{id}', [NocCrudController::class, 'updateInstallation'])->name('instalasi.update');
            Route::delete('/instalasi/{id}', [NocCrudController::class, 'destroyInstallation'])->name('instalasi.destroy');
            // Export routes
            Route::get('/instalasi/export/excel', [NocCrudController::class, 'exportExcelInstallation'])->name('instalasi.export.excel');
            Route::get('/instalasi/export/csv', [NocCrudController::class, 'exportCsvInstallation'])->name('instalasi.export.csv');

            // Maintenance
            Route::get('/maintenance', [NocAdminController::class, 'maintenance'])->name('maintenance');
            Route::get('/maintenance/create', [NocCrudController::class, 'createMaintenance'])->name('maintenance.create');
            Route::post('/maintenance/store', [NocCrudController::class, 'storeMaintenance'])->name('maintenance.store');
            Route::get('/maintenance/{id}', [NocCrudController::class, 'showMaintenance'])->name('maintenance.show');
            Route::get('/maintenance/{id}/edit', [NocCrudController::class, 'editMaintenance'])->name('maintenance.edit');
            Route::post('/maintenance/{id}', [NocCrudController::class, 'updateMaintenance'])->name('maintenance.update');
            Route::delete('/maintenance/{id}', [NocCrudController::class, 'destroyMaintenance'])->name('maintenance.destroy');
            // Export routes
            Route::get('/maintenance/export/excel', [NocCrudController::class, 'exportExcelMaintenance'])->name('maintenance.export.excel');
            Route::get('/maintenance/export/csv', [NocCrudController::class, 'exportCsvMaintenance'])->name('maintenance.export.csv');

            // Keluhan
            Route::get('/keluhan', [NocAdminController::class, 'keluhan'])->name('keluhan');
            Route::get('/keluhan/create', [NocCrudController::class, 'createComplaint'])->name('keluhan.create');
            Route::post('/keluhan/store', [NocCrudController::class, 'storeComplaint'])->name('keluhan.store');
            Route::get('/keluhan/{id}', [NocCrudController::class, 'showComplaint'])->name('keluhan.show');
            Route::get('/keluhan/{id}/edit', [NocCrudController::class, 'editComplaint'])->name('keluhan.edit');
            Route::post('/keluhan/{id}', [NocCrudController::class, 'updateComplaint'])->name('keluhan.update');
            Route::delete('/keluhan/{id}', [NocCrudController::class, 'destroyComplaint'])->name('keluhan.destroy');
            // Export routes
            Route::get('/keluhan/export/excel', [NocCrudController::class, 'exportExcelComplaint'])->name('keluhan.export.excel');
            Route::get('/keluhan/export/csv', [NocCrudController::class, 'exportCsvComplaint'])->name('keluhan.export.csv');

            // Terminasi
            Route::get('/terminasi', [NocAdminController::class, 'terminasi'])->name('terminasi');
            Route::get('/terminasi/create', [NocCrudController::class, 'createTermination'])->name('terminasi.create');
            Route::post('/terminasi/store', [NocCrudController::class, 'storeTermination'])->name('terminasi.store');
            Route::get('/terminasi/{id}', [NocCrudController::class, 'showTermination'])->name('terminasi.show');
            Route::get('/terminasi/{id}/edit', [NocCrudController::class, 'editTermination'])->name('terminasi.edit');
            Route::post('/terminasi/{id}', [NocCrudController::class, 'updateTermination'])->name('terminasi.update');
            Route::delete('/terminasi/{id}', [NocCrudController::class, 'destroyTermination'])->name('terminasi.destroy');
            // Export routes
            Route::get('/terminasi/export/excel', [NocCrudController::class, 'exportExcelTermination'])->name('terminasi.export.excel');
            Route::get('/terminasi/export/csv', [NocCrudController::class, 'exportCsvTermination'])->name('terminasi.export.csv');

            // Test route for installation first record (without auth for testing)
            Route::get('/test/installation-first', [\App\Http\Controllers\Admin\NocTestController::class, 'getFirstInstallation'])->name('test.installation.first')->withoutMiddleware(['auth', 'App\Http\Middleware\RedirectByRole']);
        });



    // ---------- Theme Toggle ----------
    Route::post('/theme-toggle', function () {
        session(['theme' => request('theme', 'light')]);
        return response()->json(['success' => true]);
    })->name('theme.toggle');

    // ---------- Backup Routes ----------
    Route::prefix('backups')->name('backups.')->group(function () {
        Route::get('/', [BackupController::class, 'index'])->name('index');
        Route::post('/create', [BackupController::class, 'store'])->name('store');
        Route::get('/download/{id}', [BackupController::class, 'download'])->name('download');
        Route::post('/restore/{id}', [BackupController::class, 'restore'])->name('restore');
        Route::delete('/{id}', [BackupController::class, 'destroy'])->name('destroy');
    });
});

use App\Http\Controllers\Frontend\TicketTrackingFrontendController;

// ================== PUBLIC NOC FORMS ==================
Route::prefix('noc')->name('noc.')->group(function () {
    Route::get('/instalasi', fn () => view('frontend.form_network_installlation'))->name('instalasi.form');
    Route::post('/instalasi/store', [NocFormController::class, 'storeInstallation'])->middleware('auth')->name('instalasi.store');

    Route::get('/maintenance', fn () => view('frontend.form_maintenance'))->name('maintenance.form');
    Route::post('/maintenance/store', [NocFormController::class, 'storeMaintenance'])->middleware('auth')->name('maintenance.store');

    Route::get('/keluhan', fn () => view('frontend.form_network_complaints'))->name('keluhan.form');
    Route::post('/keluhan/store', [NocFormController::class, 'storeComplaint'])->middleware('auth')->name('keluhan.store');

    Route::get('/terminasi', fn () => view('frontend.form_service_termination'))->name('terminasi.form');
    Route::post('/terminasi/store', [NocFormController::class, 'storeTermination'])->middleware('auth')->name('terminasi.store');
});

// ================== PUBLIC API: Ticket Tracking ==================
Route::prefix('api/tracking')->name('api.tracking.')->group(function () {
    Route::get('/{nomor_tiket}', [TicketTrackingController::class, 'track'])->name('track');
    Route::get('/tenant/{nomor_tenant}', [TicketTrackingController::class, 'getByTenant'])->name('tenant');
    Route::post('/search', [TicketTrackingController::class, 'search'])->name('search');
    Route::post('/add', [TicketTrackingController::class, 'addTrackingEntry'])->name('add');
    Route::post('/{nomor_tiket}', [TicketTrackingController::class, 'updateTicket'])->name('update');
});

// Frontend routes for ticket tracking
Route::prefix('ticket-tracking')->name('ticket-tracking.')->group(function () {
    Route::get('/', [TicketTrackingFrontendController::class, 'index'])->name('index');
    Route::get('/add', [TicketTrackingFrontendController::class, 'create'])->name('create');
    Route::post('/add', [TicketTrackingFrontendController::class, 'store'])->name('add');
});

// Ticket detail page
Route::get('/ticket-detail/{nomor_tiket}', [App\Http\Controllers\Frontend\ProfileController::class, 'showTicketDetail'])
    ->middleware(['auth'])
    ->name('ticket.detail');

// Import default auth routes
require __DIR__.'/auth.php';
