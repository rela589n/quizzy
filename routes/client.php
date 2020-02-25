<?php

/*
|--------------------------------------------------------------------------
| Client Routes
|--------------------------------------------------------------------------
|
| Here is where you can register client routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group group and prefixed with '/client'.
| Now create something great!
|
*/

Route::get('/', 'LoginController@showLoginForm')->name('.login');
Route::post('/', 'LoginController@login');

Route::post('/logout', 'LoginController@logout')->name('.logout');

Route::get('/dashboard', function () {
    return view('pages.client.dashboard');
})->name('.dashboard');

Route::prefix('/tests')
    ->name('.tests')
    ->namespace('Tests')
    ->group(function () {

        $routePatterns = Route::getPatterns();

        Route::prefix('/{subject}')
            ->where(['subject' => $routePatterns['name']])
            ->name('.subject')
            ->group(function () use (&$routePatterns) {

                Route::prefix('/{test}')
                    ->where(['test' => $routePatterns['name']])
                    ->name('.test')
                    ->group(function () use (&$routePatterns) {

                        Route::get('/', 'TestsController@showSingleTestForm');
                        Route::post('/', 'TestsController@finishTest');
                    });

                /*
                 * Single subject page with his tests list
                 * client.tests.subject.test
                 */
                Route::get('/', 'SubjectsController@showSingleSubject');

            });

        /*
         *  List of all subjects
         */
        Route::get('/', 'SubjectsController@showAll');
    });

Route::get('/404', function () {
    return 'check logging';
})->middleware('logging');

