<?php

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

Route::get('/penjual/register', function () {
    return view('penjual.register');
})->middleware('guest')->name('register.penjual');

Route::get('/penjual/inactive', function () {
    return view('penjual.inactive');
})->name('inactive.penjual');

Route::get('/', function () {
    return redirect()->route('filament.penjual.auth.login');
})->middleware('guest')->name('login');