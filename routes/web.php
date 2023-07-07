<?php

use App\Http\Controllers\c_category;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\itemController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('item', [itemController::class, 'index'])->name('item.index');
Route::get('item/create', [itemController::class, 'create'])->name('item.create');
Route::post('item/store', [itemController::class, 'store'])->name('item.store');
Route::get('item/edit/{id}', [itemController::class, 'edit'])->name('item.edit');
Route::put('item/update/{id}', [itemController::class, 'update'])->name('item.update');
Route::get('item/delete/{id}', [itemController::class, 'destroy'])->name('item.delete');
Route::get('item/activate/{id}', [itemController::class, 'activate'])->name('item.activate');


Route::get('dashboard', [dashboardController::class, 'index'])->name('dashboard.index');
Route::get('category', [CategoryController::class, 'index'])->name('category.index');
Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
Route::get('category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
Route::put('category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
Route::get('category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');



