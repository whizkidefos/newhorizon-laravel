<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\Frontend\ContactController;
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Authentication Routes
Auth::routes(['verify' => true]);

// Protected Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // User Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Shifts
    Route::resource('shifts', ShiftController::class);
    Route::post('shifts/{shift}/check-in', [ShiftController::class, 'checkIn'])->name('shifts.check-in');
    Route::post('shifts/{shift}/check-out', [ShiftController::class, 'checkOut'])->name('shifts.check-out');
    Route::post('shifts/{shift}/location', [ShiftController::class, 'updateLocation'])->name('shifts.update-location');
    
    // Courses
    Route::resource('courses', CourseController::class);
    Route::post('courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('users', Admin\UserController::class);
    Route::resource('shifts', Admin\ShiftController::class);
    Route::resource('courses', Admin\CourseController::class);
    
    // Reports
    Route::get('/reports/shifts', [Admin\ReportController::class, 'shifts'])->name('admin.reports.shifts');
    Route::get('/reports/users', [Admin\ReportController::class, 'users'])->name('admin.reports.users');
});

// require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
