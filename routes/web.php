<?php

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::name('dashboard.')
    ->prefix('dashboard')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {
        Route::get('/users', App\Http\Livewire\User\Index::class)->name('user.index');
        Route::get('/roles', App\Http\Livewire\Role\Index::class)->name('role.index');
        Route::get('/shops', App\Http\Livewire\Shop\Index::class)->name('shop.index');
        Route::get('/products', App\Http\Livewire\Product\Index::class)->name('product.index');
    });

Route::get('/landing', [App\Http\Controllers\GeneralController::class, 'noauth'])->name('noauth');
Route::middleware(['auth:sanctum', 'verified'])
    ->name('general.')
    ->group(function () {
        Route::get('/', App\Http\Livewire\General\Index::class)->name('index');
        Route::get('/toko/{id}', App\Http\Livewire\General\Slug::class)->name('show');
    });

Route::get('/city/{id}', [App\Http\Controllers\AddressController::class, 'city'])->name('city');
Route::get('/kecamatan/{id}', [App\Http\Controllers\AddressController::class, 'kecamatan'])->name('kecamatan');
Route::get('/kelurahan/{id}', [App\Http\Controllers\AddressController::class, 'kelurahan'])->name('kelurahan');
