<?php

use App\Http\Controllers\Frontend\{
    HomeController,
    AboutController,
    ServiceController,
    ContactController
};
use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\{
    LoginController,
    RegisterController,
    ForgotPasswordController,
    ResetPasswordController
};
use App\Http\Controllers\FaviconController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Favicon
Route::get('/favicon.svg', [FaviconController::class, 'svg']);

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Auth::routes(['verify' => true, 'register' => true]); // Enable registration for healthcare professionals

/*
|--------------------------------------------------------------------------
| Healthcare Professional Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');
    
    // Documents
    Route::resource('documents', DocumentController::class);
    
    // Available Shifts
    Route::get('/available-shifts', [ShiftController::class, 'available'])->name('shifts.available');
    Route::post('/shifts/{shift}/apply', [ShiftController::class, 'apply'])->name('shifts.apply');
    
    // My Shifts
    Route::get('/my-shifts', [ShiftController::class, 'myShifts'])->name('shifts.my');
    Route::post('/shifts/{shift}/check-in', [ShiftController::class, 'checkIn'])->name('shifts.check-in');
    Route::post('/shifts/{shift}/check-out', [ShiftController::class, 'checkOut'])->name('shifts.check-out');
    
    // Training & Courses
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead']);
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Admin Management (Super Admin Only)
        Route::middleware(['super_admin'])->group(function () {
            Route::resource('admins', Admin\AdminController::class);
        });
        
        // User Management
        Route::resource('users', Admin\UserController::class);
        Route::post('users/{user}/verify-documents', [Admin\UserController::class, 'verifyDocuments'])
            ->name('users.verify-documents');
        
        // Shift Management
        Route::resource('shifts', Admin\ShiftController::class);
        Route::post('shifts/{shift}/assign', [Admin\ShiftController::class, 'assign'])->name('shifts.assign');
        Route::get('shifts/{shift}/track', [Admin\ShiftController::class, 'track'])->name('shifts.track');
        
        // Course Management
        Route::resource('courses', Admin\CourseController::class);
        Route::get('courses/{course}/enrollments', [Admin\CourseController::class, 'enrollments'])
            ->name('courses.enrollments');
        
        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/shifts', [Admin\ReportController::class, 'shifts'])->name('shifts');
            Route::get('/users', [Admin\ReportController::class, 'users'])->name('users');
            Route::get('/courses', [Admin\ReportController::class, 'courses'])->name('courses');
            Route::get('/export/{type}', [Admin\ReportController::class, 'export'])->name('export');
        });
        
        // Settings
        Route::get('/settings', [Admin\SettingController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [Admin\SettingController::class, 'update'])->name('settings.update');
    });