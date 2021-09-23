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
    });

Route::get('/city/{id}', [App\Http\Controllers\AddressController::class, 'city']);
Route::get('/kecamatan/{id}', [App\Http\Controllers\AddressController::class, 'kecamatan']);
Route::get('/kelurahan/{id}', [App\Http\Controllers\AddressController::class, 'kelurahan']);
