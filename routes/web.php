<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Reports Routes (Resource, except 'show')
    Route::resource('reports', ReportController::class)->except(['show']);
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::get('/reports/manage', [ReportController::class, 'manage'])->name('reports.manage');
});

require __DIR__.'/auth.php';
