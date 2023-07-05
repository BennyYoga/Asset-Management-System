<?php

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

Route::get('dashboard', [dashboardController::class, 'index'])->name('dashboard.index');
Route::get('item', [itemController::class, 'index'])->name('item.index');
Route::get('item/create', [itemController::class, 'create'])->name('item.create');
Route::post('item/store', [itemController::class, 'store'])->name('item.store');
