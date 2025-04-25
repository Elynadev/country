<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
// routes/web.php
use App\Http\Controllers\ContactController;

// Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
// Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
// Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');


// // Accueil ou liste des contacts
// Route::get('/contact', [ContactController::class, 'index'])->name('contacts.index');

// // Ajouter un contact
// Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');

// // Supprimer un contact
// Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');

// (Facultatif) Modifier un contact
Route::put('/contacts/{id}', [ContactController::class, 'update'])->name('contacts.update');

// // (Facultatif) Formulaire d’édition
// Route::get('/contacts/{id}/edit', [ContactController::class, 'edit'])->name('contacts.edit');

// Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
// Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
// Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');

Route::get('/contacts', [ContactController::class, 'index']);
Route::post('/contacts', [ContactController::class, 'store']);
Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/contact', function () {
    return Inertia::render('ContactComponent');
})->middleware(['auth', 'verified'])->name('contact');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/notifications', function () {
    return view('notifications');
})->name('notifications.index');


require __DIR__.'/auth.php';
