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


Route::prefix('/tests')
    ->name('.tests')
    ->namespace('Tests')
    ->group(function () {

        $routePatterns = Route::getPatterns();

        Route::get('/new', 'SubjectsController@showNewSubjectForm')->name('.new');
        Route::post('/new', 'SubjectsController@newSubject');

        Route::prefix('/{subject}')
            ->where(['subject' => $routePatterns['name']])
            ->name('.subject')
            ->group(function () use (&$routePatterns) {

                Route::get('/settings', 'SubjectsController@showUpdateSubjectForm')->name('.settings');
                Route::post('/settings', 'SubjectsController@updateSubject');

                Route::get('/new', 'TestsController@showNewTestForm')->name('.new');
                Route::post('/new', 'TestsController@newTest');

                Route::prefix('/{test}')
                    ->where(['test' => $routePatterns['name']])
                    ->name('.test')
                    ->group(function () use (&$routePatterns) {

                        Route::get('/settings', 'TestsController@showUpdateTestForm')->name('settings');

                        Route::get('/', 'QuestionsController@showCreateUpdateForm');
                        Route::post('/', 'QuestionsController@createUpdate');
                    });
                /*
                 * Show single subject with his tests list
                 * admin.tests.subject.test
                 */
                Route::get('/', 'SubjectsController@showSingleSubject');
            });

        /*
         *  List of all subjects
         */
        Route::get('/', 'SubjectsController@showAll');
    });


Route::prefix('users')
    ->name('.users')
    ->group(function () {
        Route::get('/', function () {
            return view('pages.admin.users-list');
        });
    });


Route::get('/tests/hello', function () {
    return 'tests hello' . Breadcrumbs::render('test');
})->name('.tests.test');

