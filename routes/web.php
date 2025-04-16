<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipientController;
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
    // return view('pages.welcome');

    if (Auth::check()) {
        return redirect('home');
    }

    return redirect('login'); // halaman publik

});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('/recipients', [RecipientController::class, 'store'])->name('recipients.store');
Route::put('/recipients/{recipient}/edit', [RecipientController::class, 'update'])->name('recipients.update');

Route::get('/transactions/print', [HomeController::class, 'print'])->name('transactions.print');
