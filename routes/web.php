<?php

use App\Http\Controllers\c_category;
use App\Http\Controllers\dashboardController;
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

Route::get('dashboard', [dashboardController::class, 'index'])->name('dashboard.index');
Route::get('category/index', [c_category::class, 'index'])->name('category.index');
Route::get('category/create', [c_category::class, 'create'])->name('category.create');
Route::post('category/store', [c_category::class, 'store'])->name('category.store');
Route::get('category/edit/{id}', [c_category::class, 'edit'])->name('category.edit');
Route::put('category/update/{id}', [c_category::class, 'update'])->name('category.update');
Route::get('category/delete/{id}', [c_category::class, 'destroy'])->name('category.destroy');



