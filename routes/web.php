<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

// Public Portfolio Main Menu & Pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('contact.store');

// Admin Panel (Protected by ADMIN_USERNAME & ADMIN_PASSWORD from .env)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])
        ->middleware('throttle:10,1')
        ->name('login.submit');

    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

        Route::get('/projects/create', [AdminController::class, 'createProject'])->name('projects.create');
        Route::post('/projects', [AdminController::class, 'storeProject'])->name('projects.store');
        Route::get('/projects/{project:slug}/edit', [AdminController::class, 'editProject'])->name('projects.edit');
        Route::put('/projects/{project:slug}', [AdminController::class, 'updateProject'])->name('projects.update');
        Route::delete('/projects/{project:slug}', [AdminController::class, 'destroyProject'])->name('projects.destroy');

        Route::patch('/messages/{message}/toggle', [AdminController::class, 'toggleMessageRead'])->name('messages.toggle');
        Route::delete('/messages/{message}', [AdminController::class, 'destroyMessage'])->name('messages.destroy');
    });
});
