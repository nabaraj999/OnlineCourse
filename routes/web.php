<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\TicketController;

Route::get('/', [PageController::class, 'home'])->name('home');
  Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
