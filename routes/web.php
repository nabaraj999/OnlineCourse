<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\PrivacyPolicyeController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Frontend\CoursesController;
use App\Http\Controllers\MentorController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::post('/', [TicketController::class, 'store'])->name('tickets.store');
Route::get('/terms-conditions', [TermsController::class, 'show'])->name('terms_conditions');
Route::get('/privacy-policy', [PrivacyPolicyeController::class, 'show'])->name('privacy_policy');


Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/mentors', [MentorController::class, 'index'])->name('mentors.index');
Route::get('/courses', [CoursesController::class, 'index'])->name('courses.index');
Route::get('/courses/{id}', [CoursesController::class, 'show'])->name('courses.show');
