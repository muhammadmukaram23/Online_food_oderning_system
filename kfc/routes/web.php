<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [HomeController::class, 'menu'])->name('menu');
Route::get('/locations', [HomeController::class, 'locations'])->name('locations');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Locations
    Route::get('/locations', [AdminController::class, 'locations'])->name('locations');
    Route::get('/locations/create', [AdminController::class, 'createLocation'])->name('locations.create');
    Route::post('/locations', [AdminController::class, 'storeLocation'])->name('locations.store');
    Route::get('/locations/{id}/edit', [AdminController::class, 'editLocation'])->name('locations.edit');
    Route::put('/locations/{id}', [AdminController::class, 'updateLocation'])->name('locations.update');
    Route::delete('/locations/{id}', [AdminController::class, 'deleteLocation'])->name('locations.destroy');
    
    // Categories
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('categories.create');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::get('/categories/{id}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'deleteCategory'])->name('categories.destroy');
    
    // Menu Items
    Route::get('/menu-items', [AdminController::class, 'menuItems'])->name('menu-items');
    Route::get('/menu-items/create', [AdminController::class, 'createMenuItem'])->name('menu-items.create');
    Route::post('/menu-items', [AdminController::class, 'storeMenuItem'])->name('menu-items.store');
    Route::get('/menu-items/{id}/edit', [AdminController::class, 'editMenuItem'])->name('menu-items.edit');
    Route::put('/menu-items/{id}', [AdminController::class, 'updateMenuItem'])->name('menu-items.update');
    Route::delete('/menu-items/{id}', [AdminController::class, 'deleteMenuItem'])->name('menu-items.destroy');
    
    // Orders
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::put('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
});
