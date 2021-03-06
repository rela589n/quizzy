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


Route::namespace('Auth')->group(
    static function () {
        Route::get('/', 'LoginController@showLoginForm')->name('.login');
        Route::post('/', 'LoginController@login');

        Route::post('/logout', 'LoginController@logout')->name('.logout');

        Route::get('/change-password', 'ChangePasswordController@showInitialPasswordChangeForm')->name(
            '.change-password'
        );
        Route::post('/change-password', 'ChangePasswordController@initialChangePassword');
    }
);

Route::get('/dashboard', 'DashboardController@showDashboardPage')->name('.dashboard');
Route::get('/documentation', 'DocumentationController@getWordDocument')->name('.documentation');

Route::prefix('/tests')
    ->name('.tests')
    ->namespace('Tests')
    ->middleware('can:access-subjects')
    ->group(
        static function () {
            $routePatterns = Route::getPatterns();

            Route::get('/new', 'SubjectsController@showNewSubjectForm')->name('.new');
            Route::post('/new', 'SubjectsController@newSubject');

            Route::prefix('/{subject}')
                ->where(['subject' => $routePatterns['name']])
                ->name('.subject')
                ->group(
                    static function () use (&$routePatterns) {
                        Route::get('/settings', 'SubjectsController@showUpdateSubjectForm')->name('.settings');
                        Route::post('/settings', 'SubjectsController@updateSubject');
                        Route::delete('/settings', 'SubjectsController@deleteSubject');

                        Route::get('/new', 'TestsController@showNewTestForm')->name('.new');
                        Route::post('/new', 'TestsController@newTest');

                        Route::prefix('/{test}')
                            ->where(['test' => $routePatterns['name']])
                            ->name('.test')
                            ->group(
                                static function () use (&$routePatterns) {
                                    Route::get('/settings', 'TestsController@showUpdateTestForm')->name('.settings');
                                    Route::post('/settings', 'TestsController@updateTest');
                                    Route::delete('/settings', 'TestsController@deleteTest');

                                    Route::get('/import', 'TestsTransferController@showImportForm')->name('.transfer');
                                    Route::post('/import', 'TestsTransferController@import');

                                    Route::get('/export', 'TestsTransferController@export')->name('.export');

                                    Route::get('/', 'QuestionsController@showCreateOrUpdateForm');
                                    Route::post('/', 'QuestionsController@createOrUpdate');
                                }
                            );
                        /*
                         * Show single subject with his tests list
                         * admin.tests.subject.test
                         */
                        Route::get('/', 'SubjectsController@showSingleSubject');
                    }
                );

            /*
             *  List of all subjects
             */
            Route::get('/', 'SubjectsController@showAll');
        }
    );


Route::prefix('/students')
    ->name('.students')
    ->namespace('Students')
    ->middleware('can:access-groups')
    ->group(
        static function () {
            $routePatterns = Route::getPatterns();

            Route::get('/new', 'DepartmentsController@showNewDepartmentForm')->name('.new');
            Route::post('/new', 'DepartmentsController@newDepartment');

            Route::prefix('/{department}')
                ->where(['department' => $routePatterns['name']])
                ->name('.department')
                ->group(
                    static function () use ($routePatterns) {
                        Route::get('/settings', 'DepartmentsController@showUpdateDepartmentForm')->name('.settings');
                        Route::post('/settings', 'DepartmentsController@updateDepartment');
                        Route::delete('/settings', 'DepartmentsController@deleteDepartment');

                        Route::get('/new', 'GroupsController@showNewGroupForm')->name('.new');
                        Route::post('/new', 'GroupsController@newGroup');

                        Route::prefix('/{group}')
                            ->where(['group' => $routePatterns['name']])
                            ->name('.group')
                            ->group(
                                static function () use (&$routePatterns) {
                                    Route::get('/settings', 'GroupsController@showUpdateGroupForm')->name('.settings');
                                    Route::post('/settings', 'GroupsController@updateGroup');
                                    Route::delete('/settings', 'GroupsController@deleteGroup');

                                    Route::get('/new', 'StudentsController@showNewStudentForm')->name('.new');
                                    Route::post('/new', 'StudentsController@newStudent');

                                    Route::prefix('/{studentId}')
                                        ->where(['studentId' => $routePatterns['id']])
                                        ->name('.student')
                                        ->group(
                                            static function () use (&$routePatterns) {
                                                Route::get('/', 'StudentsController@showUpdateFormOrInfoPage');
                                                Route::post('/', 'StudentsController@updateStudent');
                                                Route::delete('/', 'StudentsController@deleteStudent');

                                                Route::get(
                                                    '/make-class-monitor',
                                                    'StudentsController@makeClassMonitor'
                                                )->name('.make-class-monitor');
                                            }
                                        );

                                    Route::get('/', 'GroupsController@showSingleGroup');
                                }
                            );

                        Route::get('/', 'GroupsController@showAll');
                    }
                );

            Route::get('/', 'DepartmentsController@showAll');
        }
    );

Route::prefix('/teachers')
    ->name('.teachers')
    ->namespace('Teachers')
    ->middleware('can:access-administrators')
    ->group(
        static function () {
            $routePatterns = Route::getPatterns();

            Route::get('/new', 'TeachersController@showNewForm')->name('.new');
            Route::post('/new', 'TeachersController@createTeacher');

            Route::prefix('/{teacherId}')
                ->where(['teacherId' => $routePatterns['id']])
                ->name('.teacher')
                ->group(
                    static function () {
                        Route::get('/', 'TeachersController@showUpdateFormOrInfoPage');
                        Route::post('/', 'TeachersController@updateTeacher');
                        Route::delete('/', 'TeachersController@deleteTeacher');
                    }
                );

            Route::get('/', 'TeachersController@showAll');
        }
    );

Route::prefix('/results')
    ->name('.results')
    ->namespace('Results')
    ->middleware('can:view-results')
    ->group(
        static function () {
            $routePatterns = Route::getPatterns();

            Route::prefix('/{subject}')
                ->where(['subject' => $routePatterns['name']])
                ->name('.subject')
                ->group(
                    static function () use (&$routePatterns) {
                        Route::prefix('/{test}')
                            ->where(['test' => $routePatterns['name']])
                            ->name('.test')
                            ->group(
                                static function () use (&$routePatterns) {
                                    Route::prefix('/statements')
                                        ->name('.statements')
                                        ->group(
                                            static function () use (&$routePatterns) {
                                                Route::get(
                                                    '/student/{testResultId}',
                                                    'StatementsController@studentStatement'
                                                )
                                                    ->where('testResultId', $routePatterns['id'])
                                                    ->name('.student');

                                                Route::get('/group', 'StatementsController@groupStatement')
                                                    ->name('.group');
                                            }
                                        );

                                    Route::get('/', 'TestResultsController@showTestResults');
                                }
                            );

                        Route::get('/', 'TestResultsController@showSelectTestPage');
                    }
                );

            Route::get('/', 'TestResultsController@showSelectSubjectPage');
        }
    );
