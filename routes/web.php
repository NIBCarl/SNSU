<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentAnalyticsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('add-new');
    }
    return Inertia::render('WelcomeStudentForm', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');

// New Thank You Page Route
Route::get('/thank-you', function () {
    return Inertia::render('ThankYou');
})->name('thank-you');

// Student submission route (public)
Route::post('/student', [StudentController::class, 'store'])->name('student.store');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Debug route to check remember token (remove in production)
Route::get('/debug-remember', function () {
    if (auth()->check()) {
        $user = auth()->user();
        return response()->json([
            'logged_in' => true,
            'user_id' => $user->id,
            'user_email' => $user->email,
            'remember_token_exists' => !empty($user->remember_token),
            'remember_token_preview' => $user->remember_token ? substr($user->remember_token, 0, 10) . '...' : null,
            'cookies' => request()->cookies->all(),
        ]);
    }
    return response()->json([
        'logged_in' => false,
        'cookies' => request()->cookies->all(),
    ]);
})->name('debug.remember');

// Protected routes
Route::middleware('auth')->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard-stats', [DashboardController::class, 'getDashboardStats']);
    Route::get('/location-stats', [DashboardController::class, 'getLocationStatistics']);
    
    // Student routes
    Route::get('/student-list', [StudentController::class, 'index'])->name('student-list');
    Route::get('/student-list/export', [StudentController::class, 'export'])->name('student-list.export');
    Route::get('/add-new', function () {
        return Inertia::render('AddNew');
    })->name('add-new');
    // Edit route removed - now handled by modal in StudentList
    // Route::get('/student/{student}/edit', [StudentController::class, 'edit']);
    Route::put('/student/{student}', [StudentController::class, 'update']);
    Route::delete('/student/{student}', [StudentController::class, 'destroy']);
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/student-analytics', [StudentAnalyticsController::class, 'index'])->name('student-analytics');
    Route::get('/analytics/demographics', [StudentAnalyticsController::class, 'getDemographics']);
    
    Route::get('/all-users', function () {
        return Inertia::render('AllUser');
    })->name('all-users');

    Route::get('/edit-page', function () {
        return Inertia::render('EditPage');
    })->name('edit-page');
    
    Route::get('/edit-user', function () {
        return inertia('EditUser');
    })->name('edit-user');
});

require __DIR__.'/auth.php';
