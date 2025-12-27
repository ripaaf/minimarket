<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/product/{id}', [WebProductController::class, 'show'])->name('product.show');
Route::post('/product/{id}/like', [\App\Http\Controllers\ProductLikeController::class, 'toggle'])->name('product.like');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');

// Profile
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

# Customer auth
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

# Admin auth & area
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware(['web'])->group(function(){
	Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
	Route::post('/admin/order/{id}/process', [AdminController::class, 'process'])->name('admin.order.process');
	Route::get('/admin/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
	Route::post('/admin/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
	Route::get('/admin/products', [AdminController::class, 'listProducts'])->name('admin.products.index');
	Route::get('/admin/products/{id}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
	Route::put('/admin/products/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
	Route::delete('/admin/products/{id}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');
	Route::get('/admin/orders/items', [AdminController::class, 'ordersWithItems'])->name('admin.orders.items');
});


// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
