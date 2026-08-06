<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// === Frontend Route ===
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    $totalLocations = \App\Models\Location::count();
    $activeLocations = \App\Models\Location::where('is_active', true)->count();
    $todayResults = \App\Models\Result::where('result_date', \Carbon\Carbon::today()->toDateString())->count();
    
    return view('dashboard', compact('totalLocations', 'activeLocations', 'todayResults'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Locations
    Route::get('/locations', [AdminController::class, 'locationsIndex'])->name('locations.index');
    Route::post('/locations', [AdminController::class, 'locationsStore'])->name('locations.store');
    Route::put('/locations/{location}', [AdminController::class, 'locationsUpdate'])->name('locations.update');
    
    // Results
    Route::get('/results', [AdminController::class, 'resultsIndex'])->name('results.index');
    Route::post('/results', [AdminController::class, 'resultsStore'])->name('results.store');
    
    // Settings
    Route::get('/settings', [AdminController::class, 'settingsIndex'])->name('settings.index');
    Route::post('/settings', [AdminController::class, 'settingsStore'])->name('settings.store');
});

// === Profile Routes (Breeze Defaults) ===
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
