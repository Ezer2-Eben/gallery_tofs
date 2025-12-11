<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes publiques (accessibles SANS connexion)
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', [AuthController::class, 'welcome'])->name('welcome');

// ⚠️ IMPORTANT : Ces routes doivent être AVANT le groupe middleware auth
// Galerie d'images - ACCESSIBLE À TOUS
Route::get('/images', [ImageController::class, 'index'])->name('images.index');

// Voir une image spécifique - ACCESSIBLE À TOUS
Route::get('/images/{image}', [ImageController::class, 'show'])->name('images.show');

/*
|--------------------------------------------------------------------------
| Routes d'authentification
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Connexion
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Inscription
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Déconnexion
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Routes protégées (nécessitent une authentification)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Gestion du profil (si ProfileController existe)
    if (class_exists(ProfileController::class)) {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    }

    // Gestion des images (création, modification, suppression)
    Route::get('/images/create', [ImageController::class, 'create'])->name('images.create');
    Route::post('/images', [ImageController::class, 'store'])->name('images.store');
    Route::get('/images/{image}/edit', [ImageController::class, 'edit'])->name('images.edit');
    Route::put('/images/{image}', [ImageController::class, 'update'])->name('images.update');
    Route::delete('/images/{image}', [ImageController::class, 'destroy'])->name('images.destroy');

    // Like une image
    Route::post('/images/{image}/like', [ImageController::class, 'like'])->name('images.like');
});