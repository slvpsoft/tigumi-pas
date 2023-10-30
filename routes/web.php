<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

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


// Just login
Route::get('/', function () {
    return view('pages.login');
})->name('login');
Route::post('loginAuth', [AuthController::class, 'login'])->name('auth.login');

Route::middleware('auth')->group(function () {
    // All Functions
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/expense', [AdminController::class, 'addExpense'])->name('expense');

    Route::post('storeExp', [AdminController::class, 'storeExpense'])->name('storeExp');
});
