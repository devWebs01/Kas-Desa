<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('/items/{item}/signature', [ItemController::class, 'saveSignature'])->name('items.signature.save');

Route::resource('recipients', App\Http\Controllers\RecipientController::class);

Route::resource('transactions', App\Http\Controllers\TransactionController::class);

Route::resource('recipients', App\Http\Controllers\RecipientController::class);

Route::resource('transactions', App\Http\Controllers\TransactionController::class);

Route::resource('recipients', App\Http\Controllers\RecipientController::class);

Route::resource('transactions', App\Http\Controllers\TransactionController::class);

Route::resource('recipients', App\Http\Controllers\RecipientController::class);

Route::resource('transactions', App\Http\Controllers\TransactionController::class);

Route::resource('recipients', App\Http\Controllers\RecipientController::class);

Route::resource('transactions', App\Http\Controllers\TransactionController::class);

Route::resource('recipients', App\Http\Controllers\RecipientController::class);

Route::resource('transactions', App\Http\Controllers\TransactionController::class);

Route::resource('recipients', App\Http\Controllers\RecipientController::class);

Route::resource('transactions', App\Http\Controllers\TransactionController::class);

Route::resource('recipients', App\Http\Controllers\RecipientController::class);

Route::resource('transactions', App\Http\Controllers\TransactionController::class);
