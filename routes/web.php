<?php

use App\Http\Controllers\c_category;
// use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\inventoryController;
use App\Http\Controllers\itemController;
use App\Http\Controllers\itemRequisitionController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ItemProcurementController;
use App\Http\Controllers\ItemTransferController;
use App\Http\Controllers\ItemUseController;
use App\Http\Controllers\ItemDisposingController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Models\Category;
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

Route::get('item', [itemController::class, 'index'])->name('item.index')->middleware('Role:Admin Local');
Route::get('item/create', [itemController::class, 'create'])->name('item.create')->middleware('menu.access:Kelola Lokasi');
Route::post('item/store', [itemController::class, 'store'])->name('item.store');
Route::get('item/edit/{id}', [itemController::class, 'edit'])->name('item.edit');
Route::put('item/update/{id}', [itemController::class, 'update'])->name('item.update');
Route::get('item/delete/{id}', [itemController::class, 'destroy'])->name('item.delete');
Route::get('item/activate/{id}', [itemController::class, 'activate'])->name('item.activate');


Route::get('/itemrequisition', [itemRequisitionController::class, 'index'])->name('itemreq.index');
Route::get('/itemrequisition/create', [itemRequisitionController::class, 'create'])->name('itemreq.create');
Route::post('/itemrequisition/store', [itemRequisitionController::class, 'store'])->name('itemreq.store');
Route::get('/itemrequisition/delete/{id}', [itemRequisitionController::class, 'destroy'])->name('itemreq.delete');
Route::get('/itemrequisition/activate/{id}', [itemRequisitionController::class, 'activate'])->name('itemreq.activate');
Route::get('/itemrequisition/edit/{id}', [itemRequisitionController::class, 'edit'])->name('itemreq.edit');
Route::post('/itemrequisition/update/{id}', [itemRequisitionController::class, 'update'])->name('itemreq.update');

Route::get('dropzone/example',[itemRequisitionController::class, 'dropzoneExamaple']);
Route::post('dropzone/store', [itemRequisitionController::class, 'dropzoneStore'])->name('dropzone.store');
Route::post('dropzone/delete', [itemRequisitionController::class, 'dropzoneDestroy'])->name('dropzone.delete');
Route::get  ('dropzone/get/{id}', [itemRequisitionController::class, 'dropzoneGet'])->name('dropzone.get');


Route::get('/inventory', [inventoryController::class, 'index'])->name('inventory.index');

Route::get('dashboard', [dashboardController::class, 'index'])->name('dashboard.index');
Route::get('category', [CategoryController::class, 'index'])->name('category.index')->middleware('menu.access:Kelola Menu');;
Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
Route::get('category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
Route::put('category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
Route::get('category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
Route::get('category/activate/{id}', [CategoryController::class, 'activate'])->name('category.activate');


Route::get('location', [LocationController::class, 'index'])->name('location.index');
Route::get('location/create', [LocationController::class, 'create'])->name('location.create');
Route::post('location/store', [LocationController::class, 'store'])->name('location.store');
Route::get('location/edit/{id}', [LocationController::class, 'edit'])->name('location.edit');
Route::post('location/update/{id}', [LocationController::class, 'update'])->name('location.update');
Route::get('location/delete/{id}', [LocationController::class, 'destroy'])->name('location.destroy');
Route::get('location/activate/{id}', [LocationController::class, 'activate'])->name('location.activate');

Route::get('/itemprocurement', [ItemProcurementController::class, 'index'])->name('itemproc.index');
Route::get('/itemprocurement/create', [ItemProcurementController::class, 'create'])->name('itemproc.create');
Route::post('/itemprocurement/store', [ItemProcurementController::class, 'store'])->name('itemproc.store');
Route::post('/itemprocurement/dropzone/store', [ItemProcurementController::class, 'dropzoneStore'])->name('itemproc.dropzoneStore');
Route::post('/itemprocurement/dropzone/delete', [ItemProcurementController::class, 'dropzoneDestroy'])->name('itemproc.dropzoneDestroy');
Route::get('/itemprocurement/edit/{id}', [ItemProcurementController::class, 'edit'])->name('itemproc.edit');
Route::post('/itemprocurement/update/{id}', [ItemProcurementController::class, 'update'])->name('itemproc.update');
Route::get('/itemprocurement/delete/{id}', [ItemProcurementController::class, 'destroy'])->name('itemproc.destroy');
Route::get('/itemprocurement/activate/{id}', [ItemProcurementController::class, 'activate'])->name('itemproc.activate');

Route::get('/itemtransfer', [ItemTransferController::class, 'index'])->name('itemtransfer.index');
Route::get('/itemtransfer/create', [ItemTransferController::class, 'create'])->name('itemtransfer.create');
Route::post('/itemtransfer/store', [ItemTransferController::class, 'store'])->name('itemtransfer.store');
Route::post('/itemtransfer/dropzone/store', [ItemTransferController::class, 'dropzoneStore'])->name('itemtransfer.dropzoneStore');
Route::post('/itemtransfer/dropzone/delete', [ItemTransferController::class, 'dropzoneDestroy'])->name('itemtransfer.dropzoneDestroy');
Route::get('/itemtransfer/edit/{id}', [ItemTransferController::class, 'edit'])->name('itemtransfer.edit');
Route::post('/itemtransfer/update/{id}', [ItemTransferController::class, 'update'])->name('itemtransfer.update');
Route::get('/itemtransfer/delete/{id}', [ItemTransferController::class, 'destroy'])->name('itemtransfer.destroy');
Route::get('/itemtransfer/activate/{id}', [ItemTransferController::class, 'activate'])->name('itemtransfer.activate');

Route::get('/itemuse', [ItemUseController::class, 'index'])->name('itemuse.index');
Route::get('/itemuse/create', [ItemUseController::class, 'create'])->name('itemuse.create');
Route::post('/itemuse/store', [ItemUseController::class, 'store'])->name('itemuse.store');
Route::get('/itemuse/edit/{id}', [ItemUseController::class, 'edit'])->name('itemuse.edit');
Route::post('/itemuse/update/{id}', [ItemUseController::class, 'update'])->name('itemuse.update');
Route::get('/itemuse/delete/{id}', [ItemUseController::class, 'destroy'])->name('itemuse.destroy');
Route::get('/itemuse/activate/{id}', [ItemUseController::class, 'activate'])->name('itemuse.activate');

Route::get('/itemdis', [ItemDisposingController::class, 'index'])->name('itemdis.index');
Route::get('/itemdis/create', [ItemDisposingController::class, 'create'])->name('itemdis.create');
Route::post('/itemdis/store', [ItemDisposingController::class, 'store'])->name('itemdis.store');
Route::get('/itemdis/edit/{id}', [ItemDisposingController::class, 'edit'])->name('itemdis.edit');
Route::post('/itemdis/update/{id}', [ItemDisposingController::class, 'update'])->name('itemdis.update');
Route::get('/itemdis/delete/{id}', [ItemDisposingController::class, 'destroy'])->name('itemdis.destroy');
Route::get('/itemdis/activate/{id}', [ItemDisposingController::class, 'activate'])->name('itemdis.activate');
Route::get('project', [ProjectController::class, 'index'])->name('project.index');
Route::get('project/create', [ProjectController::class, 'create'])->name('project.create');
Route::post('project/store', [ProjectController::class, 'store'])->name('project.store');
Route::get('project/edit/{id}', [ProjectController::class, 'edit'])->name('project.edit');
Route::put('project/update/{id}', [ProjectController::class, 'update'])->name('project.update');
Route::get('project/delete/{id}', [ProjectController::class, 'destroy'])->name('project.destroy');
Route::get('project/activate/{id}', [ProjectController::class, 'activate'])->name('project.activate');


Route::get('role', [RoleController::class, 'index'])->name('role.index');
Route::get('role/create', [RoleController::class, 'createRoleLocation'])->name('role.create');
Route::post('role/store', [RoleController::class, 'storeRoleLocation'])->name('roleLocation.store');
Route::get('role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
Route::put('role/update/{id}', [RoleController::class, 'update'])->name('role.update');
Route::get('role/delete/{id}', [RoleController::class, 'destroy'])->name('role.destroy');



Route::get('/login', function () {
    return view('Login/login');
});


// Route::get('/tiket/edit/{id}', [c_kabkota::class, 'edit'])->name('kabkota.edit');
Route::get('user/create', [UserController::class, 'create'])->name('user.create');
Route::post('user/store', [UserController::class, 'store'])->name('user.store');
Route::get('user', [UserController::class, 'index'])->name('user.index');


Route::get('login', [AuthController::class, 'index'])->name('login');
// Route::get('changePassword', [AuthController::class, 'changePassword'])->name('changePassword.index');
// Route::put('updatePassword/{id}', [AuthController::class, 'updatePassword'])->name('updatePassword');
// Route::get('logout', [AuthController::class, 'logout']);
Route::get('post-logout', [AuthController::class, 'logout'])->name('logout');
Route::get('tampil', [AuthController::class, 'tampil'])->name('tampil');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('lala', [RoleController::class, 'storeRoleLocation'])->name('lala');

