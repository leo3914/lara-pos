<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EmployeeController;
use App\Models\Product;
use FontLib\Table\Type\name;

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

// Route::get('/voucher', function () {
//     return view('voucher');
// });

// Route::get('/test',function () {
//     return session()->flush();
// });

Route::get('/',function () {
    return view('auth.login');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// For Cashier
Route::middleware(['auth','user-access:0'])->group(function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/add-to-ses', [ProductController::class, 'addToSes'])->name('add.to.Ses');
    Route::get('/empty-cart', [ProductController::class, 'emptyCart'])->name('empty.cart');
    Route::get('/remove-cart/{id}', [ProductController::class, 'removeCart'])->name('remove.cart');
    Route::get('/qty-search',[ProductController::class, 'qtySearch'])->name('qty.search');
    Route::post('/confirm',[ProductController::class, 'confirm'])->name('confirm');
    Route::get('/order', [ProductController::class, 'orderList'])->name('order');
    // Route::get('/voucher{id}',[ProductController::class, 'voucher'])->name('voucher');
    Route::get('/product-list',[ProductController::class, 'productList'])->name('product.list');
    Route::get('/history',[ProductController::class, 'history'])->name('history');
    Route::get('/profile-cashier',[EmployeeController::class, 'cashierProfile'])->name('profile.cashier');
});

// For Admin
Route::middleware(['auth','user-access:1'])->group(function(){
    Route::get('/admin/home',[HomeController::class, 'adminHome'])->name('admin.home');

    Route::get('/admin/category', [ProductController::class, 'category'])->name('category');
    Route::post('/admin/category-add', [ProductController::class, 'categoryAdd'])->name('category.add');
    Route::get('/admin/category-delete/{id}', [ProductController::class, 'categoryDelete'])->name('category.delete');

    Route::get('/admin/product', [ProductController::class, 'product'])->name('product');
    Route::get('/admin/category-search', [ProductController::class, 'categorySearch'])->name('category.search');
    Route::post('/admin/product-add', [ProductController::class, 'productAdd'])->name('product.add');
    Route::post('/admin/product-edit', [ProductController::class, 'productEdit'])->name('product.edit');
    Route::get('/admin/product-delete/{id}', [ProductController::class, 'productDelete'])->name('product.delete');

    Route::get('/admin/employee-detail', [EmployeeController::class, 'employeeDetail'])->name('employee.detail');
    Route::get('/admin/employee', [EmployeeController::class, 'employee'])->name('employee');
    Route::post('/admin/employee-add', [EmployeeController::class, 'employeeAdd'])->name('employee.add');

    Route::get('/admin/profile',[EmployeeController::class, 'profile'])->name('profile');
    Route::get('/admin/emp-search',[EmployeeController::class, 'empSearch'])->name('emp.search');
    Route::get('/admin/role-change/{user_id}/{role}',[EmployeeController::class, 'roleChange'])->name('role.change');
    Route::get('/admin/role-delete/{id}',[EmployeeController::class, 'empDelete'])->name('emp.delete');

    Route::get('/admin/product-search', [ProductController::class, 'productSearch'])->name('product.search');
    Route::get('/admin/today-sale', [ProductController::class, 'todaySale'])->name('today');
    Route::get('/admin/history',[ProductController::class, 'adminHistory'])->name('admin.history');
});
Route::get('/voucher{id}',[ProductController::class, 'voucher'])->name('voucher');
Route::post('/change-pass',[HomeController::class, 'changePass'])->name('pass.change');
