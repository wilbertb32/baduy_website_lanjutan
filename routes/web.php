<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LogoutConfirmationController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\SocialiteController;

// Route untuk guest (tidak perlu login)
Route::get('/', [HomeController::class, 'index'])->name('homepage');
Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace');
Route::get('/aboutUs', function () {
    return view('aboutUs');
})->name('aboutUs');

// Artikel routes - URUTAN PENTING: /create HARUS SEBELUM /{id}
Route::get('/artikel', [ArticleController::class, 'index'])->name('artikel');

// Route yang memerlukan login
Route::middleware(['auth'])->group(function () {
    Route::get('/artikel/create', [ArticleController::class, 'create'])->name('artikel.create'); // PINDAH KE SINI
    Route::post('/artikel', [ArticleController::class, 'store'])->name('artikel.store');
    
    // Edit Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// PINDAH KE BAWAH SETELAH /create
Route::get('/artikel/{id}', [ArticleController::class, 'show'])->name('artikel.show')->where('id', '[0-9]+'); // TAMBAH CONSTRAINT ID HARUS ANGKA

// Route login dan register dengan middleware guest
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

    // Password Reset Routes
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');
    
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');
    
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');
    
    Route::post('/reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

// Route untuk konfirmasi logout
Route::middleware('auth')->group(function () {
    Route::get('/auth/confirm-logout', [LogoutConfirmationController::class, 'show'])->name('auth.confirm-logout');
    Route::post('/auth/confirm-logout', [LogoutConfirmationController::class, 'confirm'])->name('auth.confirm-logout.submit');
    Route::post('/auth/cancel-logout', [LogoutConfirmationController::class, 'cancel'])->name('auth.confirm-logout.cancel');
    
    // Route logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Routes untuk Admin dan Superadmin
Route::middleware(['auth', 'CheckRole:admin,superadmin'])->prefix('admin')->group(function () {
    // Admin Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    // Article management - PASTIKAN ROUTE INI ADA
    Route::post('/articles/{id}/approve', [AdminController::class, 'approveArticle'])->name('admin.articles.approve');
    Route::post('/articles/{id}/reject', [AdminController::class, 'rejectArticle'])->name('admin.articles.reject');

    // Product CRUD
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Carousel CRUD
    Route::post('/carousels', [CarouselController::class, 'store'])->name('carousels.store');
    Route::put('/carousels/{carousel}', [CarouselController::class, 'update'])->name('carousels.update');
    Route::delete('/carousels/{carousel}', [CarouselController::class, 'destroy'])->name('carousels.destroy');
});

// Routes khusus untuk Superadmin
Route::middleware(['auth', 'CheckRole:superadmin'])->prefix('superadmin')->group(function () {
    Route::get('/', [SuperAdminController::class, 'index'])->name('superadmin.dashboard');

    // Article management untuk superadmin - TAMBAH ROUTE REJECT
    Route::post('/articles/{id}/approve', [SuperAdminController::class, 'approveArticle'])->name('superadmin.articles.approve');
    Route::post('/articles/{id}/reject', [SuperAdminController::class, 'rejectArticle'])->name('superadmin.articles.reject');
    
    // User management
    Route::post('/promote', [SuperAdminController::class, 'promoteToAdmin'])->name('superadmin.promote');
    Route::post('/demote', [SuperAdminController::class, 'demoteAdmin'])->name('superadmin.demote');
    Route::delete('/users/{id}', [SuperAdminController::class, 'deleteUser'])->name('superadmin.users.delete');
    
    // Update user role
    Route::put('/roles/{user}', [RoleController::class, 'update'])->name('roles.update');
    Route::post('/roles/promote', [RoleController::class, 'promoteToAdmin'])->name('roles.promote');
});

// Route untuk menampilkan gambar dari tabel images
Route::get('/image/{id}', [ImageController::class, 'show'])->name('image.show');

// Route untuk login google
Route::controller(SocialiteController::class)->group(function () {
    Route::get('auth/google',  'googleLogin')->name('auth.google');
    Route::get('auth/google-callback', 'googleAuthentication')->name('auth.google-callback');
});