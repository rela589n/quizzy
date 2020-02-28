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

Route::namespace('Auth')->group(function () {
    Route::get('/', 'LoginController@showLoginForm')->name('.login');
    Route::post('/', 'LoginController@login');

    Route::post('/logout', 'LoginController@logout')->name('.logout');

    Route::get('/change-password', 'ChangePasswordController@showInitialPasswordChangeForm')->name('.change-password');
    Route::post('/change-password', 'ChangePasswordController@initialChangePassword');
});

Route::get('/dashboard', 'DashboardController@showDashboardPage')->name('.dashboard');

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

