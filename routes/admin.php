<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group and prefixed with '/admin'.
| Now create something great!
|
*/

Route::get('/', function () {
    return view('pages.admin.auth');
})->name('.auth');

Route::get('/dashboard', function () {

    return view('pages.admin.dashboard');

})->name('.dashboard');

Route::prefix('tests')
    ->name('.tests')
    ->group(function () {
        Route::get('/', function () {
            return view('pages.admin.subjects-list');
        });
    });

Route::prefix('users')
    ->name('.users')
    ->group(function () {
        Route::get('/', function () {
            return "users";
        });
    });


Route::get('/tests/hello', function () {
    return 'tests hello' . Breadcrumbs::render('test');
})->name('.tests.test');

