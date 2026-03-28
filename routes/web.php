<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\TrainingCourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\EducationHistoryController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // --- Admin Only ---
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });

    // --- Admin & HR Only ---
    Route::middleware(['role:Admin,HR'])->group(function () {
        Route::resource('departments', DepartmentController::class);
        Route::resource('positions', PositionController::class);
        Route::resource('employees', EmployeeController::class)->except(['index', 'show']);
    });

    // --- Admin, HR, Manager ---
    Route::middleware(['role:Admin,HR,Manager'])->group(function () {
        Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
    });

    // --- Admin, HR, Accountant, Manager (Viewing Attendance - ALL) ---
    // Moved index out for universal access with internal filtering
    Route::middleware(['role:Admin,HR,Accountant,Manager'])->group(function () {
        // No longer limiting index here
    });

    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');

    // --- Auth (Everyone can check in/out) ---
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');

    // --- Leave Requests ---
    Route::resource('leave-requests', LeaveRequestController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::middleware(['role:Admin,Manager,HR'])->group(function () {
        Route::post('/leave-requests/{leave_request}/approve', [LeaveRequestController::class, 'approve'])->name('leave-requests.approve');
        Route::post('/leave-requests/{leave_request}/reject', [LeaveRequestController::class, 'reject'])->name('leave-requests.reject');
    });

    // --- Recruitment (Admin & HR) ---
    Route::middleware(['role:Admin,HR'])->group(function () {
        Route::resource('job-postings', JobPostingController::class)->except(['show']);
        Route::resource('candidates', CandidateController::class)->only(['index', 'create', 'store', 'update', 'destroy']);
        Route::resource('contracts', ContractController::class)->only(['store', 'update', 'destroy']);
        Route::resource('training-courses', TrainingCourseController::class)->only(['store', 'update', 'destroy']);
        Route::resource('education-histories', EducationHistoryController::class)->only(['store', 'update', 'destroy']);
    });

    // Everyone can view their own contracts and training
    Route::get('/contracts', [ContractController::class, 'index'])->name('contracts.index');
    Route::get('/contracts/{contract}', [ContractController::class, 'show'])->name('contracts.show');
    Route::get('/training-courses', [TrainingCourseController::class, 'index'])->name('training-courses.index');

    // --- Payroll (Admin & Accountant) - Management Only --- 
    Route::middleware(['role:Admin,Accountant'])->group(function () {
        Route::resource('payroll', PayrollController::class)->except(['index', 'show']);
    });
    
    // Everyone can view their own salary slips
    Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
    Route::get('/payroll/{employee}', [PayrollController::class, 'show'])->name('payroll.show');

    // Profile & Notifications
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});
