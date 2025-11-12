<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::resource('companies', CompanyController::class)->middleware(['auth']);
Route::resource('contacts', ContactController::class)->middleware(['auth']);

// Rutas adicionales para búsqueda y filtros
Route::get('companies/search', [CompanyController::class, 'search'])->name('companies.search')->middleware('auth');
Route::get('contacts/search', [ContactController::class, 'search'])->name('contacts.search')->middleware('auth');
Route::get('companies/{company}/contacts', [ContactController::class, 'byCompany'])->name('contacts.by-company')->middleware('auth');

require __DIR__.'/auth.php';
