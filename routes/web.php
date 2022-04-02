<?php

use App\Http\Controllers\AddressesController;
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

Route::get('/', [AddressesController::class, 'default']);
Route::post('feedback', [AddressesController::class, 'store'])->name('feedback');
Route::get('{address}-{blockchain}-address', [AddressesController::class, 'index'])->name('address-blockchain');
