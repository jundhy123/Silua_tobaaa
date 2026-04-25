<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\About;

// Controllers Umum
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\TestimonialController;

// Admin Controllers
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\CompanyProfileController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AboutController;

/*
|--------------------------------------------------------------------------
| 1. RUTE PUBLIK (Bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', function () {
    $products = Product::with(['reviews.user'])->latest()->get(); 
    return view('user.products', compact('products'));
})->name('user.products');

Route::get('/profil', [HomeController::class, 'profile'])->name('user.profile');
Route::get('/galeri', [HomeController::class, 'gallery'])->name('user.gallery');
Route::get('/testimoni', [TestimonialController::class, 'index'])->name('user.testimoni');
Route::get('/about', [HomeController::class, 'about'])->name('user.about');


/*
|--------------------------------------------------------------------------
| 2. RUTE GUEST (Hanya jika BELUM login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/portal', fn() => view('auth.portal'))->name('portal');

    // USER AUTH
    Route::prefix('user')->group(function () {
        Route::get('/login', [UserAuthController::class, 'showLogin'])->name('user.login');
        Route::post('/login', [UserAuthController::class, 'login'])->name('user.login.post');
        Route::get('/register', [UserAuthController::class, 'showRegister'])->name('user.register');
        Route::post('/register', [UserAuthController::class, 'register'])->name('user.register.post');
    });

    // ALIAS LOGIN DEFAULT
    Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');

    // ADMIN AUTH
    Route::prefix('admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    });
});


/*
|--------------------------------------------------------------------------
| 3. RUTE TERPROTEKSI (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

    /*
    |--- AREA KHUSUS ADMIN (Role: Admin) ---
    */
    Route::middleware('can:access-admin')->prefix('admin')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // CRUD PRODUK
        Route::resource('produk', ProductController::class)
            ->names('admin.produk')
            ->except(['show']);

        // KELOLA PESANAN MASUK
        Route::get('/pesanan', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::patch('/pesanan/update/{id}', [OrderController::class, 'updateStatus'])->name('admin.orders.update');
        Route::delete('/pesanan/hapus/{id}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');

        // KELOLA GALERI
        Route::resource('gallery', GalleryController::class)
            ->names('admin.gallery')
            ->except(['show']);

        // ✅ PERBAIKAN DI SINI (PROFILE JADI CRUD)
        Route::resource('profile', CompanyProfileController::class)
            ->names('admin.profile');

        // KELOLA TIM
        Route::resource('teams', TeamController::class)
            ->names('admin.teams');

        // CRUD ABOUT
        Route::resource('about', AboutController::class)
            ->names('admin.about');
    });


    /*
    |--- AREA KHUSUS PEMBELI (Role: Pelanggan) ---
    */
    Route::middleware('can:access-customer')->group(function () {
        
        // CART
        Route::post('/cart/add', [CartController::class, 'store'])->name('cart.store');
        Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
        
        // CHECKOUT
        Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
        Route::get('/pesanan-saya', fn() => view('user.orders'))->name('user.orders');
        Route::post('/order/process', [UserAuthController::class, 'processOrder'])->name('order.process');

        // WISHLIST
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('user.wishlist');
        Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

        // REVIEW
        Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store');
        Route::delete('/review/delete/{id}', [ReviewController::class, 'destroy'])->name('review.destroy');

        // TESTIMONI
        Route::post('/testimoni', [TestimonialController::class, 'store'])->name('testimoni.store');
        Route::patch('/testimoni/{id}', [TestimonialController::class, 'update'])->name('testimoni.update');
        Route::delete('/testimoni/{id}', [TestimonialController::class, 'destroy'])->name('testimoni.destroy');
    });
});