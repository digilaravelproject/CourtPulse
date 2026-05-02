<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\CourtController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\User\AdvocateController;
use App\Http\Controllers\User\ConnectionController;
use App\Http\Controllers\User\FeedbackController as UserFeedbackController;
use App\Http\Controllers\User\GuestController;
use App\Http\Controllers\User\ProfessionalController;
use App\Http\Controllers\User\SupportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC / LANDING ROUTES (No Authentication Required)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/begin-find', [SearchController::class, 'index'])->name('find');

Route::controller(PageController::class)->group(function () {
    Route::get('/blogs', 'blogs')->name('blogs');
    Route::get('/latest-updates', 'updates')->name('updates');
    Route::get('/contact-us', 'contact')->name('contact');
    Route::get('/careers', 'careers')->name('careers');
});

/*
|--------------------------------------------------------------------------
| 2. GUEST AUTHENTICATION ROUTES (Login, Unified Register, Password Reset)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // Login Flow
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login/send-otp', [AuthController::class, 'sendLoginOtp'])->name('login.send-otp');
    Route::get('/login/verify', [AuthController::class, 'showLoginVerify'])->name('login.verify');
    Route::post('/login/verify', [AuthController::class, 'verifyLoginOtp'])->name('login.verify.submit');

    // Password Reset (Laravel Built-in)
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

// Unified Registration Flow (Accessible to Guests & Unverified Logged-in Users)
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'postRegister'])->name('register.post');

/*
|--------------------------------------------------------------------------
| 3. AUTHENTICATED ROUTES (Needs Login, But Account Status Pending allowed)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // OTP Verification for Registration (AJAX)
    Route::post('/register/verify-otp', [AuthController::class, 'verifyRegisterOtp'])->name('register.otp.verify.post');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Pending Verification Page
    Route::get('/under-verification', function () {
        return view('auth.under-verification');
    })->name('verification.pending');
});

/*
|--------------------------------------------------------------------------
| 4. SECURE & VERIFIED ROUTES (Needs Login + Active Account Status)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'account.status'])->group(function () {

    // Global Dashboard Redirector
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Feedback & User Details
    Route::controller(UserFeedbackController::class)->group(function () {
        Route::get('/feedback', 'showPage')->name('feedback');
        Route::post('/feedback', 'store')->name('feedback.store');
        Route::get('/user/{user}/detail', 'userDetail')->name('user.detail');
    });

    // Connections / Networking
    Route::prefix('connections')->name('connections.')->controller(ConnectionController::class)->group(function () {
        Route::get('/', 'myConnections')->name('index');
        Route::post('/send', 'send')->name('send');
        Route::patch('/{connectionRequest}/accept', 'accept')->name('accept');
        Route::patch('/{connectionRequest}/reject', 'reject')->name('reject');
    });
});

/*
|--------------------------------------------------------------------------
| 5. ROLE-SPECIFIC DASHBOARDS & ACTIONS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'account.status'])->group(function () {

    // Advocate Role
    Route::middleware(['role:advocate'])->prefix('advocate')->name('advocate.')->controller(AdvocateController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/profile', 'profile')->name('profile');
        Route::post('/profile', 'updateProfile')->name('profile.update');
        Route::get('/search-clerks', 'searchClerks')->name('search.clerks');
    });

    // Professional Role (CA/CS, Agent)
    Route::middleware(['role:ca_cs|agent'])->prefix('professional')->name('professional.')->controller(ProfessionalController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/profile', 'profile')->name('profile');
        Route::post('/profile', 'updateProfile')->name('profile.update');
    });

    // Support Role (Court Clerk, IP Clerk)
    Route::middleware(['role:court_clerk|ip_clerk'])->prefix('support')->name('support.')->controller(SupportController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/profile', 'profile')->name('profile');
        Route::post('/profile', 'updateProfile')->name('profile.update');
        Route::get('/advocates', 'viewAdvocates')->name('advocates');
    });

    // Guest Role
    Route::middleware(['role:guest'])->prefix('guest')->name('guest.')->controller(GuestController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/advocates', 'advocates')->name('advocates');
        Route::get('/clerks', 'clerks')->name('clerks');
    });
});

/*
|--------------------------------------------------------------------------
| 6. ADMIN MANAGEMENT ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin|super_admin'])->prefix('admin')->name('admin.')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // System Management (Verification, Menus)
    Route::prefix('manage')->name('manage.')->controller(AdminManagementController::class)->group(function () {
        Route::get('/users', 'usersIndex')->name('users');
        Route::post('/users/{user}/verify', 'verifyUser')->name('users.verify');
        Route::get('/menus', 'menusIndex')->name('menus');
        Route::patch('/menus/{menu}', 'updateMenu')->name('menus.update');
    });

    // Courts CRUD (CourtController — AJAX)
    Route::prefix('courts')->name('courts.')->controller(CourtController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{court}', 'update')->name('update');
        Route::patch('/{court}/toggle', 'toggle')->name('toggle');
        Route::delete('/{court}', 'destroy')->name('destroy');
    });

    // Legacy Admin Routes (Maintained for compatibility)
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::patch('/users/{user}/verify', [AdminController::class, 'verifyUser'])->name('users.verify');
    Route::patch('/users/{user}/reject', [AdminController::class, 'rejectUser'])->name('users.reject');
    Route::get('/feedback', [AdminController::class, 'feedback'])->name('feedback');
});

/*
|--------------------------------------------------------------------------
| 7. SUPER ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:super_admin'])->prefix('super-admin')->name('super.')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/roles', [RolePermissionController::class, 'roles'])->name('roles');
    Route::get('/activity-logs', [SuperAdminController::class, 'activityLogs'])->name('activity');
});
