<?php

use App\Http\Controllers\Auth\EnrollmentLoginController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\Frontend\CoursesController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\PrivacyPolicyeController; // Consider renaming to PrivacyPolicyController
use App\Http\Controllers\Student\CertificateController;
use App\Http\Controllers\Student\MyCoursesController;
use App\Http\Controllers\Student\PaymentReceiptController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\SuggestionController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CertificateVerificationController;
use Illuminate\Support\Facades\Route;

// Home & Static Pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/terms-conditions', [TermsController::class, 'show'])->name('terms_conditions');
Route::get('/privacy-policy', [PrivacyPolicyeController::class, 'show'])->name('privacy_policy');

// Contact
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Ticket (from home page)
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');

// Mentors
Route::get('/mentors', [MentorController::class, 'index'])->name('mentors.index');

// routes/web.php

Route::get('/courses', [CoursesController::class, 'index'])
     ->name('courses.index');

Route::get('/courses/{course:slug}', [CoursesController::class, 'show'])
     ->name('courses.show');
// routes/web.php
Route::post('/courses/enroll',[CoursesController::class, 'enrollStore'])
    ->name('courses.enroll.store');

// Blogs
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('blogs.show');

/// routes/web.php

Route::get('/login', [EnrollmentLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [EnrollmentLoginController::class, 'login']);
Route::post('/logout', [EnrollmentLoginController::class, 'logout'])
    ->name('logout');

// routes/web.php
Route::middleware('auth:web')->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])
        ->name('student.dashboard');

Route::get('/my-courses', [MyCoursesController::class, 'index'])
         ->name('student.my-courses');

Route::get('/payment-receipts', [PaymentReceiptController::class, 'index'])->name('student.payment-receipts');
    Route::get('/receipt/{enrollmentId}', [PaymentReceiptController::class, 'show'])->name('student.receipt.show');
    Route::get('/receipt/{enrollmentId}/pdf', [PaymentReceiptController::class, 'pdf'])->name('student.receipt.pdf');

Route::get('/suggestions', [SuggestionController::class, 'index'])
         ->name('student.suggestions.index');

Route::post('/suggestions', [SuggestionController::class, 'store'])
         ->name('student.suggestions.store');

Route::get('/profile', [ProfileController::class, 'index'])->name('student.profile');
Route::post('/profile', [ProfileController::class, 'update'])->name('student.profile.update');

Route::get('/student/certificates', [CertificateController::class, 'index'])
        ->name('student.certificates.index');

    Route::get('/certificate/{id}/download', [CertificateController::class, 'download'])
        ->name('certificate.download');
});
