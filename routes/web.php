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
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BankDetailsController;
use App\Http\Controllers\WorkHistoryController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\ComplaintController;
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

// Jobs
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/search', [JobController::class, 'search'])->name('jobs.search');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

// Legal Pages
Route::view('/terms', 'legal.terms')->name('terms');
Route::view('/privacy', 'legal.privacy')->name('privacy');

// Policy Pages
Route::get('/privacy-policy', [PolicyController::class, 'privacy'])->name('policy.privacy');
Route::get('/terms-and-conditions', [PolicyController::class, 'terms'])->name('policy.terms');
Route::get('/cookie-policy', [PolicyController::class, 'cookies'])->name('policy.cookies');

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
| Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Bank Details
    Route::get('/profile/bank-details', [BankDetailsController::class, 'index'])->name('profile.bank-details');
    Route::post('/profile/bank-details', [BankDetailsController::class, 'store'])->name('profile.bank-details.store');
    Route::patch('/profile/bank-details/{bankDetail}', [BankDetailsController::class, 'update'])->name('profile.bank-details.update');
    
    // Work History
    Route::get('/profile/work-history', [WorkHistoryController::class, 'index'])->name('profile.work-history');
    Route::post('/profile/work-history', [WorkHistoryController::class, 'store'])->name('profile.work-history.store');
    Route::patch('/profile/work-history/{workHistory}', [WorkHistoryController::class, 'update'])->name('profile.work-history.update');
    Route::delete('/profile/work-history/{workHistory}', [WorkHistoryController::class, 'destroy'])->name('profile.work-history.destroy');
    
    // Training Records
    Route::get('/profile/trainings', [TrainingController::class, 'index'])->name('profile.trainings');
    Route::post('/profile/trainings', [TrainingController::class, 'store'])->name('profile.trainings.store');
    Route::patch('/profile/trainings/{training}', [TrainingController::class, 'update'])->name('profile.trainings.update');
    Route::delete('/profile/trainings/{training}', [TrainingController::class, 'destroy'])->name('profile.trainings.destroy');

    // Course routes
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
    Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
    Route::get('/courses/{course}/progress', [CourseController::class, 'progress'])->name('courses.progress');
    Route::post('/courses/{course}/progress', [CourseController::class, 'updateProgress'])->name('courses.update-progress');

    // Shift routes
    Route::get('/shifts', [ShiftController::class, 'index'])->name('shifts.index');
    Route::get('/shifts/my-shifts', [ShiftController::class, 'myShifts'])->name('shifts.my-shifts');
    Route::post('/shifts/{shift}/book', [ShiftController::class, 'book'])->name('shifts.book');
    Route::post('/shifts/{shift}/cancel', [ShiftController::class, 'cancel'])->name('shifts.cancel');

    // Available Shifts
    Route::get('/available-shifts', [ShiftController::class, 'available'])->name('shifts.available');
    Route::post('/shifts/{shift}/apply', [ShiftController::class, 'apply'])->name('shifts.apply');
    
    // My Shifts
    Route::get('/my-shifts', [ShiftController::class, 'myShifts'])->name('shifts.my');
    Route::post('/shifts/{shift}/check-in', [ShiftController::class, 'checkIn'])->name('shifts.check-in');
    Route::post('/shifts/{shift}/check-out', [ShiftController::class, 'checkOut'])->name('shifts.check-out');
    Route::get('/shifts/{shift}/checkout-options', [ShiftController::class, 'checkoutOptions'])->name('shifts.checkout-options');
    Route::post('/shifts/{shift}/quick-timesheet', [ShiftController::class, 'quickSubmitTimesheet'])->name('shifts.quick-timesheet');
    
    // Timesheet routes
    Route::resource('timesheets', TimesheetController::class);
    Route::get('/shifts/{shift}/timesheet/create', [TimesheetController::class, 'createFromShift'])->name('timesheets.create-from-shift');
    
    // Complaint routes
    Route::resource('complaints', ComplaintController::class);
    Route::get('/shifts/{shift}/complaint/create', [ComplaintController::class, 'createFromShift'])->name('complaints.create-from-shift');
    Route::post('/shifts/{shift}/complaint/quick-submit', [ComplaintController::class, 'quickSubmit'])->name('complaints.quick-submit');
    
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
Route::middleware(['auth', 'verified', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Admin Management (Super Admin Only)
    Route::middleware([\App\Http\Middleware\SuperAdminMiddleware::class])->group(function () {
        Route::resource('admins', Admin\AdminController::class);
    });
    
    // User Management
    Route::resource('users', Admin\UserController::class);
    Route::post('users/{user}/verify-documents', [Admin\UserController::class, 'verifyDocuments'])
        ->name('users.verify-documents');
    Route::post('/users/{user}/export', [Admin\UserController::class, 'export'])->name('users.export');
    
    // Shift Management
    Route::resource('shifts', Admin\ShiftController::class);
    Route::get('/shifts/{shift}/assign', [Admin\ShiftController::class, 'showAssignForm'])->name('shifts.assign');
    Route::post('/shifts/{shift}/assign', [Admin\ShiftController::class, 'assignUser'])->name('shifts.assign.store');
    Route::get('shifts/{shift}/track', [Admin\ShiftController::class, 'track'])->name('shifts.track');
    
    // Shift Locations Management
    Route::resource('shift-locations', Admin\ShiftLocationController::class);
    
    // Course Management
    Route::resource('courses', Admin\CourseController::class);
    Route::get('courses/{course}/enrollments', [Admin\CourseController::class, 'enrollments'])
        ->name('courses.enrollments');
    
    // Timesheet Management
    Route::get('timesheets-dashboard', [Admin\TimesheetController::class, 'dashboard'])->name('timesheets.dashboard');
    Route::resource('timesheets', Admin\TimesheetController::class);
    Route::post('timesheets/{timesheet}/approve', [Admin\TimesheetController::class, 'approve'])->name('timesheets.approve');
    Route::post('timesheets/{timesheet}/reject', [Admin\TimesheetController::class, 'reject'])->name('timesheets.reject');
    Route::get('/timesheets-export', [Admin\TimesheetExportController::class, 'index'])->name('timesheets.export');
    Route::post('/timesheets-export/download', [Admin\TimesheetExportController::class, 'export'])->name('timesheets.export.download');
    Route::get('/timesheets-export/{format}', [Admin\TimesheetExportController::class, 'export'])->name('timesheets.export.format');
    
    // Complaint Management
    Route::get('complaints-dashboard', [Admin\ComplaintController::class, 'dashboard'])->name('complaints.dashboard');
    Route::resource('complaints', Admin\ComplaintController::class);
    Route::post('/complaints/{complaint}/in-progress', [Admin\ComplaintController::class, 'markInProgress'])->name('complaints.in-progress');
    Route::post('/complaints/{complaint}/resolve', [Admin\ComplaintController::class, 'resolve'])->name('complaints.resolve');
    Route::post('/complaints/{complaint}/close', [Admin\ComplaintController::class, 'close'])->name('complaints.close');
    Route::get('/complaints-export', [Admin\ComplaintExportController::class, 'index'])->name('complaints.export');
    Route::post('/complaints-export/download', [Admin\ComplaintExportController::class, 'export'])->name('complaints.export.download');
    
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