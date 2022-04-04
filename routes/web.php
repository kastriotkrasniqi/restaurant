<?php


use App\Http\Controllers\OrderController;
use App\Http\Controllers\SectionController;
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

//orders
Route::get('/order/getProductsById/{id}', [OrderController::class, 'getProductsById']);
Route::get('/order', [OrderController::class, 'index']);
Route::get('/order/getTableId/{table_id}', [OrderController::class, 'getTableId']);
Route::get('/order/getSaleDetailsByTable/{table_id}', [OrderController::class, 'getSaleDetailsByTable']);
Route::post('/order/orderFood', [OrderController::class, 'orderFood']);
Route::post('/order/deleteSaleDetail', [OrderController::class, 'deleteSaleDetail']);



//sections
Route::get('/section/getTablesById/{id}', [SectionController::class, 'getTablesById']);
Route::get('/', [SectionController::class, 'index']);