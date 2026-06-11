<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\About;

// Controllers Umum
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserAuthController;
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
| 1. RUTE PUBLIK
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
| 2. RUTE GUEST
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // LOGIN UNIFIKASI (Admin & Pelanggan)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // REGISTER (Khusus Pelanggan)
    Route::get('/register', [UserAuthController::class, 'showRegister'])->name('user.register');
    Route::post('/register', [UserAuthController::class, 'register'])->name('user.register.post');
});


/*
|--------------------------------------------------------------------------
| 3. RUTE TERPROTEKSI
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |--- AREA ADMIN ---
    */
    Route::middleware('can:access-admin')->prefix('admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::resource('produk', ProductController::class)
            ->names('admin.produk')
            ->except(['show']);

        // PESANAN MASUK (DARI CART & DIRECT ORDER)
        Route::get('/pesanan', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::patch('/pesanan/{order}/update', [OrderController::class, 'updateStatus'])->name('admin.orders.update');
        Route::delete('/pesanan/{order}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');

        Route::resource('gallery', GalleryController::class)
            ->names('admin.gallery')
            ->except(['show']);

        Route::resource('profile', CompanyProfileController::class)
            ->names('admin.profile');

        Route::resource('teams', TeamController::class)
            ->names('admin.teams');

        Route::resource('about', AboutController::class)
            ->names('admin.about');
    });


    /*
    |--- AREA CUSTOMER ---
    */
    Route::middleware('can:access-customer')->group(function () {

        // CART
        Route::post('/cart/add', [CartController::class, 'store'])->name('cart.store');
        Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

        // CHECKOUT CART (WhatsApp)
        Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

        // DIRECT ORDER
        Route::post('/direct-order', [CartController::class, 'directOrder'])->name('cart.directOrder');

        // ORDERS
        Route::get('/pesanan-saya', [CartController::class, 'myOrders'])->name('user.orders');

        // WISHLIST
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('user.wishlist');
        Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

        // REVIEW
        Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store');
        Route::delete('/review/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');

        // TESTIMONI
        Route::post('/testimoni', [TestimonialController::class, 'store'])->name('testimoni.store');
        Route::patch('/testimoni/{testimonial}', [TestimonialController::class, 'update'])->name('testimoni.update');
        Route::delete('/testimoni/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimoni.destroy');
    });
});
