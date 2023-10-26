<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarTest;

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
    return view('pages.login');
});

Route::get('/expense', function () {
    return view('pages.add');
});

// Route::get('/dashboard', function () {
//     return view('pages.home');
// });

Route::get('/dashboard', [CalendarTest::class, 'showCalendar']);

