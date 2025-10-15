<?php

use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductController as AdminProfileController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\DiscountController as AdminDiscountController;
use App\Http\Controllers\Admin\MessageController as AdminTransactionController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\MessageController as AdminBlogController;


use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
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
Route::middleware(['auth:admin', 'role:admin,manager'])->prefix('admin')->name('admin.')->group(function () {

    // dashboard
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // users
    Route::get('users/{role?}', [AdminUserController::class, 'index'])->name('users.index'); // نمایش با فیلتر نقش
    Route::resource('users', AdminUserController::class)->except(['index']); // create, store, show, edit, update, destroy

    // manager profile 
    Route::resource('profile', AdminProfileController::class)->only(['edit', 'update']);

    // products
    Route::resource('products', AdminProductController::class);
    Route::post('products/{product}/toggle', [AdminProductController::class, 'toggle'])->name('products.toggle');

    // categories
    Route::resource('categories', AdminCategoryController::class);

    // orders
    Route::resource('orders', AdminOrderController::class);

    // banners
    Route::resource('banners', AdminBannerController::class);
    Route::post('banners/{banner}/toggle', [AdminBannerController::class, 'toggle'])->name('banners.toggle');

    // comments
    Route::resource('comments', AdminCommentController::class);
    Route::post('comments/{comment}/toggle', [AdminCommentController::class, 'toggle'])->name('comments.toggle');

    // discounts
    Route::resource('discounts', AdminDiscountController::class);

    // transactions
    Route::resource('transactions', AdminTransactionController::class);

    // messages
    Route::resource('messages', AdminMessageController::class);

});

//authors
Route::middleware(['auth', 'role:author,manager,admin'])->prefix('author')->name('author.')->group(function () {
    Route::resource('blog', AdminBlogController::class);
});
//
Route::middleware(['auth', 'role:manager,admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('blog', AdminBlogController::class);
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
