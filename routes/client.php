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
    return view('pages.client.auth');
})->name('.auth');

Route::get('/dashboard', function () {
    return view('pages.client.dashboard');
})->name('.dashboard');

Route::prefix('tests')
    ->name('.tests')
    ->group(function () {
        Route::get('/', function () {
            return view('pages.client.subjects-list');
        });
    });

Route::get('/404', function () {
    return 'check logging';
})->middleware('logging');

