<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\CourtController as AdminCourtController;
use App\Http\Controllers\Admin\DocumentController as AdminDocumentController;
use App\Http\Controllers\User\AdvocateController;
use App\Http\Controllers\User\ClerkController;
use App\Http\Controllers\User\CaController;
use App\Http\Controllers\User\GuestController;
use App\Http\Controllers\User\DocumentController as UserDocumentController;
use App\Http\Controllers\User\FeedbackController as UserFeedbackController;
use App\Http\Controllers\User\ConnectionController;
use App\Http\Controllers\DashboardController;
use App\Models\User;
use App\Models\Court;

// ─── DASHBOARD REDIRECT ───────────────────────────────────────────────────────
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

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

    Route::get('/register',          [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register/step-1',  [AuthController::class, 'registerStep1'])->name('register.step1');
});

Route::middleware('auth')->group(function () {
    // Registration Multi-step Flow (Post-registration login)
    Route::get('/otp-verify',        [AuthController::class, 'showOtpVerify'])->name('otp.verify');
    Route::post('/otp-verify',       [AuthController::class, 'verifyOtp'])->name('otp.verify.submit');
    Route::post('/otp-resend',       [AuthController::class, 'resendOtp'])->name('otp.resend');

    Route::get('/register/role',     [AuthController::class, 'showRoleSelection'])->name('register.role');
    Route::post('/register/role',    [AuthController::class, 'storeRoleSelection'])->name('register.role.store');

    Route::get('/register/details',  [AuthController::class, 'showDetailsForm'])->name('register.details');
    Route::post('/register/details', [AuthController::class, 'storeDetails'])->name('register.details.store');
    
    Route::get('/register/documents', [AuthController::class, 'showDocumentsForm'])->name('register.documents');
    Route::post('/register/upload-doc', [AuthController::class, 'uploadDoc'])->name('register.upload-doc');
    Route::post('/register/complete', [AuthController::class, 'completeRegistration'])->name('register.complete');
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
    Route::get('/feedback',           [UserFeedbackController::class, 'showPage'])->name('feedback');
    Route::post('/feedback',          [UserFeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/user/{user}/detail', [UserFeedbackController::class, 'userDetail'])->name('user.detail');


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
        Route::get('/advocates',         [GuestController::class, 'advocates'])->name('advocates');
        Route::get('/advocates/{user}',  [GuestController::class, 'showAdvocate'])->name('advocate.detail');
        Route::get('/clerks',            [GuestController::class, 'clerks'])->name('clerks');
        Route::get('/clerks/{user}',     [GuestController::class, 'showClerk'])->name('clerk.detail');
    });

// ─── ADVOCATE ROUTES ──────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:advocate'])
    ->prefix('advocate')->name('advocate.')->group(function () {
        Route::get('/dashboard',         [AdvocateController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile',           [AdvocateController::class, 'profile'])->name('profile');
        Route::post('/profile',          [AdvocateController::class, 'updateProfile'])->name('profile.update');
        Route::get('/documents',         [UserDocumentController::class, 'myDocuments'])->name('documents');
        Route::post('/documents/upload', [UserDocumentController::class, 'upload'])->name('documents.upload');
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
        Route::get('/documents',         [UserDocumentController::class, 'myDocuments'])->name('documents');
        Route::post('/documents/upload', [UserDocumentController::class, 'upload'])->name('documents.upload');
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
        Route::get('/documents',         [UserDocumentController::class, 'myDocuments'])->name('documents');
        Route::post('/documents/upload', [UserDocumentController::class, 'upload'])->name('documents.upload');
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
        Route::patch('/documents/{document}/review', [AdminDocumentController::class, 'review'])->name('documents.review');

        // Courts
        Route::resource('courts', AdminCourtController::class);

        // Feedback — name 'admin.feedback' hai (shared 'feedback' se conflict avoid karne ke liye)
        Route::get('/feedback',               [AdminController::class, 'feedback'])->name('feedback');
        Route::delete('/feedback/{feedback}', [UserFeedbackController::class, 'destroy'])->name('feedback.destroy');
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

        // User Management
        Route::get('/users',                 [SuperAdminController::class, 'allUsers'])->name('users');
        Route::delete('/users/{user}/delete', [SuperAdminController::class, 'deleteUser'])->name('users.delete');

        // Activity logs
        Route::get('/activity-logs', [SuperAdminController::class, 'activityLogs'])->name('activity');
        
        // Super Admin Dashboard also shows Admin things if needed, but for now we use separate controllers.
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
    });
