<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home screen for route '/' and '/home'

Route::get('/{name}', function () {
    return view('welcome');
})->where('name','|home');



// Product resources for users

Route::group(['middleware' => ['auth:sanctum','verified']], function(){
    Route::resources([
        'products' => ProductController::class
    ]);
});




// Admin Login Routes and 

Route::get('/admin-panel', [UserController::class,'showAdminLogin'])->name('admin.login.show');

Route::post('/admin-panel', [UserController::class,'AdminLogin'])->name('admin.login');



// 'isAdmin' middleware implementation for '/admin/products/show' route
//  can be extened for more routes using middleware groups

Route::group(['middleware' => ['auth:sanctum','verified', 'isAdmin']], function(){
    Route::get('/admin/products/show', [UserController::class, 'showAllProducts'])->name('admin.products.show');
});


// Custom Logout method for calling outside of Fortify's default implementation

Route::get('logout', function(){
    auth('web')->logout();
    Session()->flush();
    return redirect('/')->with('status','Successfully logged out.');
})->name('logout');



// Experimental comments


// Route::middleware(['auth:sanctum', 'verified'])->get('/products', ['ProductController','show'])->name('products');

// Route::group(['middleware' => ['auth:sanctum','verified']], function(){
    // Route::get('/products/show', [App\Http\Controllers\ProductController::class,'show'])->name('products.show');

    // Route::get('/products', [App\Http\Controllers\ProductController::class,'index'])->name('products.index');
    // Route::get('/products/create', [App\Http\Controllers\ProductController::class,'create'])->name('products.create');
    // Route::post('/products', [App\Http\Controllers\ProductController::class,'store'])->name('products.store');
    // Route::get('/products/{id}/edit', [App\Http\Controllers\ProductController::class,'edit'])->name('products.edit');
    // Route::post('/products/{id}', [App\Http\Controllers\ProductController::class,'update'])->name('products.update');
    // Route::post('/products/{id}', [App\Http\Controllers\ProductController::class,'destroy'])->name('products.destory');
// });
