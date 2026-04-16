<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvocateController;
use App\Http\Controllers\ClerkController;
use App\Http\Controllers\CaController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\CourtController;
use App\Http\Controllers\ConnectionController;
use App\Models\User;
use App\Models\Court;
use Illuminate\Support\Facades\Route;

// ─── LANDING PAGE ─────────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('landing.index', [
        'totalAdvocates' => User::role('advocate')->where('status', 'active')->count(),
        'totalClerks'    => User::role('clerk')->where('status', 'active')->count(),
        'totalCourts'    => Court::where('is_active', true)->count(),
    ]);
})->name('home');

// ─── AUTH ROUTES ──────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/register/step-2', [AuthController::class, 'showStep2'])->name('register.step2');
    Route::post('/register/step-2', [AuthController::class, 'storeStep2'])->name('register.step2.store');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/under-process', function () {
    return view('auth.under-process');
})->name('under-process')->middleware('auth');
// ─── PASSWORD RESET (Laravel Built-in) ───────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password',        [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password',       [App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password',        [App\Http\Controllers\Auth\NewPasswordController::class, 'store'])->name('password.update');
});

// ─── SHARED ROUTES (all authenticated users) ──────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/feedback',           [FeedbackController::class, 'showPage'])->name('feedback');
    Route::post('/feedback',          [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/user/{user}/detail', [FeedbackController::class, 'userDetail'])->name('user.detail');


    // Connection Routes — NEW
    Route::post('/connections/send',                          [ConnectionController::class, 'send'])->name('connections.send');
    Route::patch('/connections/{connectionRequest}/accept',   [ConnectionController::class, 'accept'])->name('connections.accept');
    Route::patch('/connections/{connectionRequest}/reject',   [ConnectionController::class, 'reject'])->name('connections.reject');
    Route::get('/connections',                                [ConnectionController::class, 'myConnections'])->name('connections.index');
});

// ─── GUEST ROUTES ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:guest|advocate|clerk|ca|admin|super_admin'])
    ->prefix('guest')->name('guest.')->group(function () {
        Route::get('/dashboard', [GuestController::class, 'dashboard'])->name('dashboard');
        Route::get('/advocates', [GuestController::class, 'advocates'])->name('advocates');
        Route::get('/clerks',    [GuestController::class, 'clerks'])->name('clerks');
    });

// ─── ADVOCATE ROUTES ──────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:advocate'])
    ->prefix('advocate')->name('advocate.')->group(function () {
        Route::get('/dashboard',         [AdvocateController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile',           [AdvocateController::class, 'profile'])->name('profile');
        Route::post('/profile',          [AdvocateController::class, 'updateProfile'])->name('profile.update');
        Route::get('/documents',         [DocumentController::class, 'myDocuments'])->name('documents');
        Route::post('/documents/upload', [DocumentController::class, 'upload'])->name('documents.upload');
        Route::get('/search-clerks',     [AdvocateController::class, 'searchClerks'])->name('search.clerks');
        Route::get('/clerks/{user}',     [AdvocateController::class, 'viewClerkProfile'])->name('clerk.profile');
        Route::get('/guests',            [AdvocateController::class, 'browseGuests'])->name('guests');
        Route::get('/guests/{user}',     [AdvocateController::class, 'viewGuestProfile'])->name('guest.profile');
    });

// ─── CLERK ROUTES ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:clerk'])
    ->prefix('clerk')->name('clerk.')->group(function () {
        Route::get('/dashboard',         [ClerkController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile',           [ClerkController::class, 'profile'])->name('profile');
        Route::post('/profile',          [ClerkController::class, 'updateProfile'])->name('profile.update');
        Route::get('/documents',         [DocumentController::class, 'myDocuments'])->name('documents');
        Route::post('/documents/upload', [DocumentController::class, 'upload'])->name('documents.upload');
        Route::get('/advocates',         [ClerkController::class, 'viewAdvocates'])->name('advocates');
        Route::get('/advocates/{user}',  [ClerkController::class, 'showAdvocate'])->name('advocate.profile');
        Route::get('/guests',            [ClerkController::class, 'browseGuests'])->name('guests');
        Route::get('/guests/{user}',     [ClerkController::class, 'viewGuestProfile'])->name('guest.profile');
    });

// ─── CA ROUTES ────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:ca'])
    ->prefix('ca')->name('ca.')->group(function () {
        Route::get('/dashboard',         [CaController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile',           [CaController::class, 'profile'])->name('profile');
        Route::post('/profile',          [CaController::class, 'updateProfile'])->name('profile.update');
        Route::get('/documents',         [DocumentController::class, 'myDocuments'])->name('documents');
        Route::post('/documents/upload', [DocumentController::class, 'upload'])->name('documents.upload');
        Route::get('/search-advocates',  [CaController::class, 'searchAdvocates'])->name('search.advocates');
    });

// ─── ADMIN ROUTES ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin|super_admin'])
    ->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Users
        Route::get('/users',                    [AdminController::class, 'users'])->name('users');
        Route::get('/users/{user}',             [AdminController::class, 'showUser'])->name('users.show');
        Route::patch('/users/{user}/verify',    [AdminController::class, 'verifyUser'])->name('users.verify');
        Route::patch('/users/{user}/reject',    [AdminController::class, 'rejectUser'])->name('users.reject');

        // Filtered lists
        Route::get('/advocates', [AdminController::class, 'advocates'])->name('advocates');
        Route::get('/clerks',    [AdminController::class, 'clerks'])->name('clerks');

        // Documents
        Route::get('/documents',                     [AdminController::class, 'documents'])->name('documents');
        Route::patch('/documents/{document}/review', [DocumentController::class, 'review'])->name('documents.review');

        // Courts
        Route::resource('courts', CourtController::class);

        // Feedback — name 'admin.feedback' hai (shared 'feedback' se conflict avoid karne ke liye)
        Route::get('/feedback',               [AdminController::class, 'feedback'])->name('feedback');
        Route::delete('/feedback/{feedback}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');
    });

// ─── SUPER ADMIN ROUTES ───────────────────────────────────────────────────────
Route::middleware(['auth', 'role:super_admin'])
    ->prefix('super-admin')->name('super.')->group(function () {

        // Roles
        Route::get('/roles',                       [RolePermissionController::class, 'roles'])->name('roles');
        Route::post('/roles',                      [RolePermissionController::class, 'createRole'])->name('roles.create');
        Route::put('/roles/{role}',                [RolePermissionController::class, 'updateRole'])->name('roles.update');
        Route::delete('/roles/{role}',             [RolePermissionController::class, 'deleteRole'])->name('roles.delete');

        // Permissions
        Route::get('/permissions',                 [RolePermissionController::class, 'permissions'])->name('permissions');
        Route::post('/permissions',                [RolePermissionController::class, 'createPermission'])->name('permissions.create');
        Route::delete('/permissions/{permission}', [RolePermissionController::class, 'deletePermission'])->name('permissions.delete');

        // Assign/Revoke roles to users
        Route::post('/assign-role/{user}',   [RolePermissionController::class, 'assignRole'])->name('assign.role');
        Route::post('/revoke-role/{user}',   [RolePermissionController::class, 'revokeRole'])->name('revoke.role');

        // User permissions
        Route::get('/users/{user}/permissions',   [RolePermissionController::class, 'userPermissions'])->name('users.permissions');
        Route::post('/users/{user}/permissions',  [RolePermissionController::class, 'updateUserPermissions'])->name('users.permissions.update');

        // Activity logs
        Route::get('/activity-logs', [SuperAdminController::class, 'activityLogs'])->name('activity');
    });
