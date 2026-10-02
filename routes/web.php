<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\Student\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/formations', [HomeController::class, 'formations'])->name('formations');
Route::get('/formations/{slug}', [HomeController::class, 'showFormation'])->name('formations.show');
Route::get('/parcours', [HomeController::class, 'parcours'])->name('parcours');
Route::get('/projets', [HomeController::class, 'projects'])->name('projects');
Route::get('/communaute', [HomeController::class, 'community'])->name('community');
Route::get('/contribuer', [HomeController::class, 'contribute'])->name('contribute');
Route::post('/contribuer', [HomeController::class, 'submitApplication'])->name('contribute.submit');
Route::get('/adhesion', [MembershipController::class, 'create'])->name('membership.create');
Route::post('/adhesion', [MembershipController::class, 'store'])->name('membership.store');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:6,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email')->middleware('throttle:5,1');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update')->middleware('throttle:5,1');

Route::middleware(['auth', 'account.active'])->group(function () {
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'send'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

/*
|--------------------------------------------------------------------------
| Student Dashboard Routes (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'account.active', 'verified'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/courses', [DashboardController::class, 'courses'])->name('dashboard.courses');
    Route::post('/enroll/{formationId}', [DashboardController::class, 'enroll'])->name('dashboard.enroll');
    Route::get('/learn/{formationId}/{courseId?}', [DashboardController::class, 'learnCourse'])->name('dashboard.learn');
    Route::post('/complete-lesson/{courseId}', [DashboardController::class, 'markLessonComplete'])->name('dashboard.complete-lesson');
    Route::get('/projects', [DashboardController::class, 'projects'])->name('dashboard.projects');
    Route::post('/projects', [DashboardController::class, 'storeProject'])->name('dashboard.projects.store');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
});

/*
|--------------------------------------------------------------------------
| Admin Dashboard Routes (Protected - Role: Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'account.active', 'verified', 'role:admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Membership requests
    Route::get('/memberships', [AdminController::class, 'memberships'])->name('memberships');
    Route::post('/memberships/{membership}/status', [AdminController::class, 'updateMembershipStatus'])
        ->name('memberships.status');

    // Users Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{id}/role', [AdminController::class, 'updateUserRole'])->name('users.role');
    Route::post('/users/{id}/status', [AdminController::class, 'toggleUserStatus'])->name('users.status');

    // Formations Management
    Route::get('/formations', [AdminController::class, 'formations'])->name('formations');
    Route::post('/formations', [AdminController::class, 'storeFormation'])->name('formations.store');
    Route::delete('/formations/{id}', [AdminController::class, 'deleteFormation'])->name('formations.delete');

    // Projects Management
    Route::get('/projects', [AdminController::class, 'projects'])->name('projects');
    Route::post('/projects', [AdminController::class, 'storeProject'])->name('projects.store');
    Route::post('/projects/{id}/approve', [AdminController::class, 'toggleProjectStatus'])->name('projects.approve');
    Route::post('/projects/{id}/featured', [AdminController::class, 'toggleProjectFeatured'])->name('projects.featured');
    Route::delete('/projects/{id}', [AdminController::class, 'deleteProject'])->name('projects.delete');

    // Applications (Formateurs / Contributeurs)
    Route::get('/applications', [AdminController::class, 'applications'])->name('applications');
    Route::post('/applications/{id}/status', [AdminController::class, 'updateApplicationStatus'])->name('applications.status');

    // Events
    Route::get('/events', [AdminController::class, 'events'])->name('events');
    Route::post('/events', [AdminController::class, 'storeEvent'])->name('events.store');
    Route::post('/events/{event}/date', [AdminController::class, 'updateEventDate'])->name('events.date');
    Route::delete('/events/{id}', [AdminController::class, 'deleteEvent'])->name('events.delete');

    // Testimonials
    Route::get('/testimonials', [AdminController::class, 'testimonials'])->name('testimonials');
    Route::post('/testimonials', [AdminController::class, 'storeTestimonial'])->name('testimonials.store');
    Route::delete('/testimonials/{id}', [AdminController::class, 'deleteTestimonial'])->name('testimonials.delete');
});
