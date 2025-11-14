<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\ActivityController;

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

Route::resource('deals', DealController::class)->middleware(['auth']);
Route::get('deals/pipeline', [DealController::class, 'pipeline'])->name('deals.pipeline')->middleware('auth');
Route::post('deals/{deal}/mark-won', [DealController::class, 'markAsWon'])->name('deals.mark-won')->middleware('auth');
Route::post('deals/{deal}/mark-lost', [DealController::class, 'markAsLost'])->name('deals.mark-lost')->middleware('auth');


Route::resource('activities', ActivityController::class)->middleware(['auth']);
Route::post('activities/{activity}/complete', [ActivityController::class, 'complete'])->name('activities.complete')->middleware('auth');
Route::get('activities/search', [ActivityController::class, 'search'])->name('activities.search')->middleware('auth');


// Notification routes
Route::get('/profile/notifications', [ProfileController::class, 'notifications'])->name('profile.notifications');
Route::put('/profile/notifications', [ProfileController::class, 'updateNotifications'])->name('profile.notifications.update');
Route::post('/profile/notifications/test', [ProfileController::class, 'testNotifications'])->name('profile.notifications.test');
require __DIR__.'/auth.php';
