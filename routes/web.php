<?php

use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\DiscountController as AdminDiscountController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

//profile
Route::prefix('account')->name('account.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//     Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('/profile', ProfileController::class)->only(['edit' , 'update']);
    Route::resource('/orders', OrderController::class)->only('index' , 'show');
    Route::resource('addresses' , AddressController::class);
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
    Route::get('/messages', [MessageController::class, 'index'])->name('messages');
});

//login admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.store');
});

//admin
Route::prefix('admin')->name('admin.')->middleware(['auth:admin','role:admin,manager,author'])->group(function () {
        Route::get('dashboard', [AdminDashboardController::class , 'index'])->name('dashboard');
        Route::resource('users', UserController::class)->only(['show','edit','update']);
        Route::resource('products', AdminProductController::class);
        Route::resource('categories', AdminCategoryController::class);
        Route::resource('orders', AdminOrderController::class);
        Route::resource('banners', AdminBannerController::class);
        Route::resource('comments', AdminCommentController::class);
        Route::resource('discounts', AdminDiscountController::class);
        Route::resource('transactions', AdminCategoryController::class);
        Route::resource('messages', AdminMessageController::class);
        Route::resource('messages', AdminBlogController::class)->middleware('role:author');

});

//app
Route::name('app.')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/welcome', [HomeController::class, 'welcome'])->name('welcome');
        Route::resource('/product' , ProductController::class)->only(['index' , 'show']);
        Route::resource('/cart', CartController::class)->middleware('auth');

        //search
        Route::get('/search', [ProductController::class, 'search'])->name('product.search');

});


require __DIR__.'/auth.php';
