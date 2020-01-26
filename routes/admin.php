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

                Route::get('/settings', function () {
                    return view('pages.admin.subjects-single-settings');
                })->name('.settings');

                Route::get('/new', function () {
                    return view('pages.admin.tests-new');
                })->name('.new');

                Route::prefix('/{test}')
                    ->where(['test' => $routePatterns['name']])
                    ->name('.test')
                    ->group(function () use (&$routePatterns) {

                        Route::get('/settings', function () {
                            return view('pages.admin.tests-single-settings');
                        })->name('settings');

                        Route::get('/', function () {
                            return view('pages.admin.tests-single');
                        });
                    });

                /*
                 * Simply the single subject routing
                 */
                Route::get('/', function (\Illuminate\Http\Request $request) {
                    return view('pages.admin.subjects-single');
                });
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

