<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\DbExportController;
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
    return view('dashboard');
});
Route::get('/columns', [ColumnController::class, 'index']);
Route::post('/columns', [ColumnController::class, 'store']);
Route::delete('/columns/{column}', [ColumnController::class, 'destroy']);
Route::post('/columns/{column}/cards', [CardController::class, 'store']);
Route::post('/columns/{column}/cards/moved', [CardController::class, 'moved']);

Route::put('/cards/{card}', [CardController::class, 'update']);

Route::get('db-export', [DbExportController::class, 'export'])->name('db.export');
