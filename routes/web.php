<?php

use App\Http\Controllers\ProductController;
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

Route::get('/', [ProductController::class, 'index']);
Route::post('/basket/add', [ProductController::class, 'add'])->name('basket.add');
Route::post('/basket/delete', [ProductController::class, 'delete'])->name('basket.delete');
Route::post('/basket/clear', [ProductController::class, 'clearBasket'])->name('basket.clear');
Route::post('/basket/update', [ProductController::class, 'update'])->name('basket.update');
