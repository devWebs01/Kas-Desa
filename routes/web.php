<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TransactionController;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
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
    $website = Setting::first();

    return view('pages.welcome', compact('website'));

});

Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/transactions/print', [TransactionController::class, 'print'])->name('transactions.print');
Route::get('/transactions/{id}/invoice', [TransactionController::class, 'invoice'])->name('transactions.invoice');

Route::get('settings/show', [SettingController::class, 'show'])->name('settings.show');
Route::post('settings/update', [SettingController::class, 'update'])->name('settings.update');
Route::post('signature/destroy', action: [SettingController::class, 'destroy'])->name('signature.destroy');
