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

Route::get('/', [AddressesController::class, 'default'])->name('default');
Route::get('/search', [AddressesController::class, 'search'])->name('search');
Route::get('/tags/{slug}', [AddressesController::class, 'tags'])->name('tags');
Route::get('/sitemap.xml', [AddressesController::class, 'sitemap'])->name('sitemap');
Route::post('feedback', [AddressesController::class, 'store'])->name('feedback');
Route::get('{address}-{blockchain}-address', [AddressesController::class, 'index'])->name('address-blockchain');
