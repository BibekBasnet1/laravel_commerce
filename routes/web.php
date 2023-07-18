<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;
use \App\Http\Middleware;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
// use App\Mail\OrderShipped;

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


// this is used for the user categories frontEndView
// Route::view('/','frontends.show');

// this is the view for the categories
// Route::view('/categories/cart','frontends.addCart')->name('frontends.addCart');


Route::view('/categories', 'frontends.categories')->name('frontends.categories');

Route::view('/sidebarCategories','frontends.sidebarCategories')->name("frontends.sidebarCategories");

// for redirecting towards the certain page
Route::get('/sidebarCategories/{id}', [App\Http\Controllers\FrontendController::class, 'sidebarCategory'])->name('frontends.sidebarCategories');


// for redirecting towards the certain page
Route::get('/checkout', [App\Http\Controllers\FrontendController::class, 'checkout'])->name('frontends.checkout');

// This route is used to show a specific category based on ID
Route::get('/', [App\Http\Controllers\FrontendController::class, 'show'])->name('frontends.show');

// to redirect to the order checkout 
Route::get('/checkout/order/items/{id}', [App\Http\Controllers\OrderController::class, 'orderCheckout'])->name('frontends.orderCheckout');

// This route is used to show a specific category based on ID
Route::get('/categories/{id}', [App\Http\Controllers\FrontendController::class, 'showCategory'])->name('frontends.categories');

// this route is adding the cart section 
Route::post('/carts',[App\Http\Controllers\CartController::class, 'store'])->name('frontends.store');

// this route is adding the cart section 
Route::post('/carts-store',[App\Http\Controllers\CartController::class, 'addToCart'])->name('frontends.addToCart');


// this is used to add the form 
Route::get('/cart-details', [App\Http\Controllers\CartController::class, 'getCartDetails'])->name('cart.details');

// this is used to get the details of the product being clicked 
Route::get('/product-details/{id}', [App\Http\Controllers\FrontendController::class, 'imageCheckout'])->name('frontends.imageCheckout');

// this is used to delete the cart
Route::post('/cart-delete', [App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');

// this is for the orders section
Route::post('order/checkout/',[App\Http\Controllers\OrderController::class , 'order'])->name('orders.order');

// for searching the orders section 
Route::post('search/',[App\Http\Controllers\FrontendController::class , 'search'])->name('frontends.search');

// for searching the page and redirecting to the new page
Route::get('searchInput/', [App\Http\Controllers\FrontendController::class, 'searchInput'])->name('frontends.searchInput');

// Route::get('displayProducts/', [App\Http\Controllers\FrontendController::class, 'displayProducts'])->name('frontends.displayProducts');

// for searching the page and redirecting to the new page
Route::post('searchInput/sortByprice/', [App\Http\Controllers\FrontendController::class, 'sortByPrice'])->name('frontends.sortByPrice');

// this is for the wishlist 
Route::post('wishlist/products',[App\Http\Controllers\WishlistController::class , 'store'])->name('wishlists.store');

// this is for the wishlist count 
Route::post('wishlist/count',[App\Http\Controllers\WishlistController::class , 'count'])->name('wishlists.count');

// this is for the wishlist details 
Route::post('allwishlist/products',[App\Http\Controllers\WishlistController::class , 'getWishListDetails'])->name('wishlists.getWishListDetails');

// this is for the wish delete
Route::post('wishlist-delete/',[App\Http\Controllers\WishlistController::class , 'destroy'])->name('wishlists.destroy');

Route::get('/login', function () 
{
    return View::name('auth.login', 'layouts.login-layout');
})->name('login');

Auth::routes();

// grouping for the admin preifx
Route::group(['prefix' => 'admin','middleware' => 'auth'],function(){

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('frontends.show');

// giving the route for the users where we pass the functioname in the controller part 
Route::get('/user', [App\Http\Controllers\UserController::class, 'getUser'])->name('users.index')->middleware('auth');

// This is all the routing for the user module
Route::get('/user/edit/{id}', [App\Http\Controllers\UserController::class, 'editUser'])->name('users.edit');
Route::post('/user/update/{id}', [App\Http\Controllers\UserController::class, 'updateUser'])->name('users.update');
Route::post('/user/delete/{id}', [App\Http\Controllers\UserController::class, 'deleteUser'])->name('users.delete');
Route::get('/user/add/', [App\Http\Controllers\UserController::class, 'addUser'])->name('users.addUser');
Route::post('/user/create/', [App\Http\Controllers\UserController::class, 'createUser'])->name('users.createUser');

// This is all the routing for the products module
Route::get('/products',[App\Http\Controllers\ProductController::class,'index'])->name('products.index')->middleware('auth');

Route::get('/products/create',[App\Http\Controllers\ProductController::class,'create'])->name('products.create');
Route::post('/products/add',[App\Http\Controllers\ProductController::class,'store'])->name('products.store');

// for editing the user
Route::get('/products/edit/{id}',[App\Http\Controllers\ProductController::class,'edit'])->name('products.edit');
Route::post('/products/edit/{id}',[App\Http\Controllers\ProductController::class,'update'])->name('products.update');

// for deleting the user
Route::post('/products/delete/{id}',[App\Http\Controllers\ProductController::class,'destroy'])->name('products.destroy');

// for restoring the feature
Route::get('/products/deletedData/',[App\Http\Controllers\ProductController::class,'deletedData'])->name('products.deletedData');

Route::post('/products/restore/{id}',[App\Http\Controllers\ProductController::class,'restore'])->name('products.restore');

// to fetch the data and return the data as json
Route::get('/user/product/{id}', [App\Http\Controllers\UserController::class, 'getUserProduct'])->name('users.getUserProduct');

// this is for the permission 
Route::get('/user/roles', [App\Http\Controllers\RolesController::class, 'index'])->name('roles.index')->middleware('auth');
Route::get('/user/roles/createRoll', [App\Http\Controllers\RolesController::class, 'create'])->name('roles.create');
Route::post('/user/roles/store', [App\Http\Controllers\RolesController::class, 'store'])->name('roles.store');
Route::get('/user/roles/edit/{id}', [App\Http\Controllers\RolesController::class, 'edit'])->name('roles.edit');
// Route::get('/user/roles/permisson/{id}', [App\Http\Controllers\RolesController::class, 'show'])->name('roles.show');
Route::post('user/roles/update/{id}', [App\Http\Controllers\RolesController::class, 'update'])->name('roles.update');
Route::post('/user/roles/destroy{id}', [App\Http\Controllers\RolesController::class, 'destroy'])->name('roles.destroy');

// this is for the permission controller
Route::get('/user/permission', [App\Http\Controllers\PermisionController::class, 'index'])->name('permissions.index')->middleware('auth');

Route::get('/user/permission/create', [App\Http\Controllers\PermisionController::class, 'create'])->name('permissions.create');
Route::post('/user/permission/store', [App\Http\Controllers\PermisionController::class, 'store'])->name('permissions.store');

Route::get('/user/permission/edit/{id}', [App\Http\Controllers\PermisionController::class, 'edit'])->name('permissions.edit');
Route::post('/user/permission/update/{id}', [App\Http\Controllers\PermisionController::class, 'update'])->name('permissions.update');

Route::post('/user/permission/delete/{id}', [App\Http\Controllers\PermisionController::class, 'destroy'])->name('permissions.destroy');

// this is for the categories section 
Route::get('/user/categories',[App\Http\Controllers\CategoryController::class , 'index'])->name('categories.index')->middleware('auth');
// thisi is used to redirect to creation page
Route::get('/user/categories/create',[App\Http\Controllers\CategoryController::class , 'create'])->name('categories.create');
// this is used to store the page
Route::post('/user/categories/store',[App\Http\Controllers\CategoryController::class , 'store'])->name('categories.store');
Route::post('/user/categories/destroy/{id}',[App\Http\Controllers\CategoryController::class , 'destroy'])->name('categories.destroy');
Route::get('/user/categories/edit/{id}',[App\Http\Controllers\CategoryController::class , 'edit'])->name('categories.edit');
Route::post('/user/categories/update/{id}',[App\Http\Controllers\CategoryController::class , 'update'])->name('categories.update');

// this is for the slider section 
Route::get('/user/sliders',[App\Http\Controllers\SliderController::class , 'index'])->name('sliders.index')->middleware('auth');
Route::get('/user/sliders/create',[App\Http\Controllers\SliderController::class , 'create'])->name('sliders.create');
Route::post('/user/sliders/store',[App\Http\Controllers\SliderController::class , 'store'])->name('sliders.store');
Route::get('/user/sliders/edit/{id}',[App\Http\Controllers\SliderController::class , 'edit'])->name('sliders.edit');
Route::post('/user/sliders/update/{id}',[App\Http\Controllers\SliderController::class , 'update'])->name('sliders.update');
Route::post('/user/sliders/destroy/{id}',[App\Http\Controllers\SliderController::class , 'destroy'])->name('sliders.destroy');


// this is for the stocks section 

Route::get('/user/products/stocks',[App\Http\Controllers\StocksController::class , 'index'])->name('stocks.index');
Route::get('/user/products/stocks/create',[App\Http\Controllers\StocksController::class , 'create'])->name('stocks.create');
Route::post('/user/products/stocks/store',[App\Http\Controllers\StocksController::class , 'store'])->name('stocks.store');
Route::get('/user/products/stocks/edit/{id}',[App\Http\Controllers\StocksController::class , 'edit'])->name('stocks.edit');
Route::post('/user/products/stocks/update/{id}',[App\Http\Controllers\StocksController::class , 'update'])->name('stocks.update');
Route::post('/user/products/stocks/delete/{id}',[App\Http\Controllers\StocksController::class , 'destroy'])->name('stocks.destroy');


});



