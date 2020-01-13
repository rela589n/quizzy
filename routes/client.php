<?php

/*
|--------------------------------------------------------------------------
| Client Routes
|--------------------------------------------------------------------------
|
| Here is where you can register client routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
| Now create something great!
|
*/

Route::get('/', function () {
    return view('client.auth')->with([
        'content' => 1123 // view('welcome')
    ]);
})->name('auth');

Route::get('/dashboard', function () {
   return view('layouts.client');
})->name('dashboard');

Route::get('/404', function () {
    return 'check logging';
})->middleware('logging');


