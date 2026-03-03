<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;

// Landing page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// User Routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/books', [UserController::class, 'books'])->name('books.index');
    Route::get('/books/{book}', [UserController::class, 'show'])->name('books.show');
    
    // Cart routes
    Route::get('/cart', [UserController::class, 'cart'])->name('user.cart.index');
    Route::post('/cart/add/{book}', [UserController::class, 'addToCart'])->name('user.cart.add');
    Route::post('/cart/update/{cart}', [UserController::class, 'updateCart'])->name('user.cart.update');
    Route::delete('/cart/remove/{cart}', [UserController::class, 'removeFromCart'])->name('user.cart.remove');
    
    // Checkout routes
    Route::get('/checkout', [UserController::class, 'checkout'])->name('user.checkout');
    Route::post('/checkout/process', [UserController::class, 'processCheckout'])->name('user.checkout.process');

     // Payment routes
    Route::get('/payment/{order}', [UserController::class, 'payment'])->name('user.payment');
    Route::post('/payment/{order}/upload', [UserController::class, 'uploadPaymentProof'])->name('user.payment.upload');

    // Orders routes
    Route::get('/orders', [UserController::class, 'orders'])->name('user.orders.index');
    Route::get('/orders/{order}', [UserController::class, 'showOrder'])->name('user.orders.show');

    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [App\Http\Controllers\ProfileController::class, 'index'])->name('index');
    Route::get('/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('edit');
    Route::put('/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('update');
    Route::get('/change-password', [App\Http\Controllers\ProfileController::class, 'changePassword'])->name('change-password');
    Route::put('/update-password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('update-password');
    });
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('books', BookController::class);
    Route::resource('categories', CategoryController::class);

    // Order Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::patch('/orders/{order}/payment', [OrderController::class, 'updatePaymentStatus'])->name('orders.update-payment');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // User Management Routes
    Route::resource('users', AdminUserController::class);
    Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
});
