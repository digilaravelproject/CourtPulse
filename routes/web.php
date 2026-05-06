<?php

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

    // Professional Role (Advocate, CA/CS, Agent) - Unified Module
    Route::middleware(['role:advocate|ca_cs|agent'])->prefix('professional')->name('professional.')->group(function () {
        Route::controller(ProfessionalController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard');
            Route::get('/profile', 'profile')->name('profile');
            Route::post('/profile', 'updateProfile')->name('profile.update');
            Route::get('/settings', 'settings')->name('settings');

            // Connection System
            Route::get('/pending-requests', 'pendingRequests')->name('pending.requests');
            Route::post('/connections/{connectionRequest}/accept', 'acceptRequest')->name('connections.accept');
            Route::delete('/connections/{connectionRequest}/reject', 'rejectRequest')->name('connections.reject');
            Route::get('/connections', 'myConnections')->name('connections');

            // Search System (Unified for all Professionals)
            Route::get('/search-clerks', 'searchClerks')->name('search.clerks');
            Route::get('/search-clerks/ajax', 'searchClerks')->name('search.clerks.ajax');

            Route::get('/search-advocates', 'searchAdvocates')->name('search.advocates');
            Route::get('/search-advocates/ajax', 'searchAdvocates')->name('search.advocates.ajax');

            Route::get('/search-courts', 'searchCourts')->name('search.courts');
            Route::get('/search-courts/ajax', 'searchCourts')->name('search.courts.ajax');
            
            // Unified Profile View
            Route::get('/user-profile/{user}', 'viewUserProfile')->name('user.profile.view');

            // Connection Request AJAX
            Route::post('/connection/send', 'sendConnection')->name('connection.send');

            // Feedback
            Route::get('/feedback', 'feedback')->name('feedback');
            Route::post('/feedback', 'submitFeedback')->name('feedback.submit');
        });
    });
    });

    // Support Role (Court Clerk, IP Clerk)
    Route::middleware(['role:court_clerk|ip_clerk'])->prefix('support')->name('support.')->group(function () {
        Route::controller(SupportController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard');
            Route::get('/profile', 'profile')->name('profile');
            Route::post('/profile', 'updateProfile')->name('profile.update');
            Route::get('/advocates', 'viewAdvocates')->name('search.advocates');
            Route::get('/advocates/{user}', 'showAdvocate')->name('advocate.profile');
            Route::get('/pending-requests', 'pendingRequests')->name('pending.requests');
            Route::patch('/requests/{id}/accept', 'acceptRequest')->name('pending.requests.accept');
            Route::delete('/requests/{id}/reject', 'rejectRequest')->name('pending.requests.reject');
            Route::get('/connections', 'myConnections')->name('connections');
            Route::get('/feedback', 'feedback')->name('feedback');
            Route::post('/feedback', 'submitFeedback')->name('feedback.submit');
            Route::post('/send-connection', 'sendConnection')->name('connection.send');
        });
    });

    // Guest Role
    Route::middleware(['role:guest'])->prefix('guest')->name('guest.')->controller(GuestController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/advocates', 'advocates')->name('advocates');
        Route::get('/clerks', 'clerks')->name('clerks');
    });


/*
|--------------------------------------------------------------------------
| 6. ADMIN MANAGEMENT ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin|super_admin'])->prefix('admin')->name('admin.')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [AdminManagementController::class, 'dashboard'])->name('dashboard');

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
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{court}/edit', 'edit')->name('edit');
        Route::put('/{court}', 'update')->name('update');
        Route::patch('/{court}/toggle', 'toggle')->name('toggle');
        Route::delete('/{court}', 'destroy')->name('destroy');
    });


    // Feedback Management
    Route::get('/feedback', [AdminManagementController::class, 'feedback'])->name('feedback');
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
