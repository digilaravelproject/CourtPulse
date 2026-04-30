<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\CourtController as AdminCourtController;
use App\Http\Controllers\Admin\DocumentController as AdminDocumentController;
use App\Http\Controllers\User\AdvocateController;
use App\Http\Controllers\User\SupportController;
use App\Http\Controllers\User\ProfessionalController;
use App\Http\Controllers\User\GuestController;
use App\Http\Controllers\User\DocumentController as UserDocumentController;
use App\Http\Controllers\User\FeedbackController as UserFeedbackController;
use App\Http\Controllers\User\ConnectionController;
use App\Http\Controllers\DashboardController;

// ─── DASHBOARD REDIRECT ───────────────────────────────────────────────────────
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware(['auth', 'account.status']);

// ─── LANDING PAGE ─────────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/begin-find', [App\Http\Controllers\SearchController::class, 'index'])->name('find');
Route::get('/blogs', [PageController::class, 'blogs'])->name('blogs');
Route::get('/latest-updates', [PageController::class, 'updates'])->name('updates');
Route::get('/contact-us', [PageController::class, 'contact'])->name('contact');
Route::get('/careers', [PageController::class, 'careers'])->name('careers');

// ─── AUTH ROUTES ──────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',             [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login/send-otp',   [AuthController::class, 'sendLoginOtp'])->name('login.send-otp');
    Route::get('/login/verify',      [AuthController::class, 'showLoginVerify'])->name('login.verify');
    Route::post('/login/verify',     [AuthController::class, 'verifyLoginOtp'])->name('login.verify.submit');

    // Registration Flow (Step-by-step)
    Route::get('/register',          [AuthController::class, 'showRegister'])->name('register');
    Route::get('/register/step-1',   [AuthController::class, 'showRegisterStep1'])->name('register.step1');
    Route::post('/register/step-1',  [AuthController::class, 'postRegisterStep1'])->name('register.step1.post');
    Route::get('/register/step-2',   [AuthController::class, 'showRegisterStep2'])->name('register.step2');
    Route::post('/register/step-2',  [AuthController::class, 'postRegisterStep2'])->name('register.step2.post');
    Route::get('/register/step-3',   [AuthController::class, 'showRegisterStep3'])->name('register.step3');
    Route::post('/register/step-3',  [AuthController::class, 'postRegisterStep3'])->name('register.step3.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/register/otp',      [AuthController::class, 'showRegisterOtp'])->name('register.otp');
    Route::post('/register/otp',     [AuthController::class, 'verifyRegisterOtp'])->name('register.otp.verify');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/under-verification', function () {
    return view('auth.under-verification');
})->name('verification.pending')->middleware('auth');

// ─── PASSWORD RESET (Laravel Built-in) ───────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password',        [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password',       [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password',        [App\Http\Controllers\Auth\NewPasswordController::class, 'store'])->name('password.update');
});

// ─── SHARED ROUTES (Verified users only) ──────────────────────────────────────
Route::middleware(['auth', 'account.status'])->group(function () {
    Route::get('/feedback',           [UserFeedbackController::class, 'showPage'])->name('feedback');
    Route::post('/feedback',          [UserFeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/user/{user}/detail', [UserFeedbackController::class, 'userDetail'])->name('user.detail');

    // Connection Routes
    Route::post('/connections/send',                          [ConnectionController::class, 'send'])->name('connections.send');
    Route::patch('/connections/{connectionRequest}/accept',   [ConnectionController::class, 'accept'])->name('connections.accept');
    Route::patch('/connections/{connectionRequest}/reject',   [ConnectionController::class, 'reject'])->name('connections.reject');
    Route::get('/connections',                                [ConnectionController::class, 'myConnections'])->name('connections.index');
});

// ─── ROLE-BASED DASHBOARDS (Verified users only) ──────────────────────────────
Route::middleware(['auth', 'account.status'])->group(function () {
    
    // Advocate
    Route::middleware(['role:advocate'])->prefix('advocate')->name('advocate.')->group(function () {
        Route::get('/dashboard',         [AdvocateController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile',           [AdvocateController::class, 'profile'])->name('profile');
        Route::post('/profile',          [AdvocateController::class, 'updateProfile'])->name('profile.update');
        Route::get('/search-clerks',     [AdvocateController::class, 'searchClerks'])->name('search.clerks');
    });

    // Professionals (CA/CS, Agent)
    Route::middleware(['role:ca_cs|agent'])->prefix('professional')->name('professional.')->group(function () {
        Route::get('/dashboard',         [ProfessionalController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile',           [ProfessionalController::class, 'profile'])->name('profile');
        Route::post('/profile',          [ProfessionalController::class, 'updateProfile'])->name('profile.update');
    });

    // Support (Court Clerk, IP Clerk)
    Route::middleware(['role:court_clerk|ip_clerk'])->prefix('support')->name('support.')->group(function () {
        Route::get('/dashboard',         [SupportController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile',           [SupportController::class, 'profile'])->name('profile');
        Route::post('/profile',          [SupportController::class, 'updateProfile'])->name('profile.update');
        Route::get('/advocates',         [SupportController::class, 'viewAdvocates'])->name('advocates');
    });

    // Guest
    Route::middleware(['role:guest'])->prefix('guest')->name('guest.')->group(function () {
        Route::get('/dashboard',         [GuestController::class, 'dashboard'])->name('dashboard');
        Route::get('/advocates',         [GuestController::class, 'advocates'])->name('advocates');
        Route::get('/clerks',            [GuestController::class, 'clerks'])->name('clerks');
    });
});

// ─── ADMIN MANAGEMENT ────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin|super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Management (Verification, Courts, Menus)
    Route::get('/manage/users',         [AdminManagementController::class, 'usersIndex'])->name('manage.users');
    Route::post('/manage/users/{user}/verify', [AdminManagementController::class, 'verifyUser'])->name('manage.users.verify');
    
    Route::get('/manage/courts',        [AdminManagementController::class, 'courtsIndex'])->name('manage.courts');
    Route::post('/manage/courts',       [AdminManagementController::class, 'storeCourt'])->name('manage.courts.store');
    Route::patch('/manage/courts/{court}', [AdminManagementController::class, 'updateCourt'])->name('manage.courts.update');

    Route::get('/manage/menus',         [AdminManagementController::class, 'menusIndex'])->name('manage.menus');
    Route::patch('/manage/menus/{menu}', [AdminManagementController::class, 'updateMenu'])->name('manage.menus.update');

    // Legacy Admin Routes (if needed for compatibility)
    Route::get('/users',                [AdminController::class, 'users'])->name('users');
    Route::get('/feedback',             [AdminController::class, 'feedback'])->name('feedback');
});

// ─── SUPER ADMIN ROUTES ───────────────────────────────────────────────────────
Route::middleware(['auth', 'role:super_admin'])->prefix('super-admin')->name('super.')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/roles',     [RolePermissionController::class, 'roles'])->name('roles');
    Route::get('/activity-logs', [SuperAdminController::class, 'activityLogs'])->name('activity');
});
