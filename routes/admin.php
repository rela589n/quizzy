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

                        Route::get('/settings', 'TestsController@showUpdateTestForm')->name('.settings');
                        Route::post('/settings', 'TestsController@updateTest');

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


Route::prefix('/students')
    ->name('.students')
    ->namespace('Students')
    ->group(function () {

        $routePatterns = Route::getPatterns();

        Route::get('/new', 'GroupsController@showNewGroupForm')->name('.new');
        Route::post('/new', 'GroupsController@newGroup');

        Route::prefix('/{group}')
            ->where(['group' => $routePatterns['name']])
            ->name('.group')
            ->group(function () use (&$routePatterns) {

                Route::get('/settings', 'GroupsController@showUpdateGroupForm')->name('.settings');
                Route::post('/settings', 'GroupsController@updateGroup');

                Route::get('/new', 'StudentsController@showNewStudentForm')->name('.new');
                Route::post('/new', 'StudentsController@newStudent');

                Route::prefix('/{studentId}')
                    ->where(['studentId' => $routePatterns['id']])
                    ->name('.student')
                    ->group(function () use (&$routePatterns) {

                        Route::get('/', 'StudentsController@showUpdateStudentForm');
                        Route::post('/', 'StudentsController@updateStudent');

                    });

                Route::get('/', 'GroupsController@showSingleGroup');
            });

        Route::get('/', 'GroupsController@showAll');
    });

Route::prefix('/teachers')
    ->name('.teachers')
    ->namespace('Teachers')
    ->group(function () {
        $routePatterns = Route::getPatterns();

        Route::get('/new', 'TeachersController@showNewForm')->name('.new');
        Route::post('/new', 'TeachersController@createTeacher');

        Route::prefix('/{teacherId}')
            ->where(['teacherId' => $routePatterns['id']])
            ->name('.teacher')
            ->group(function () {

                Route::get('/', 'TeachersController@showUpdateForm');
                Route::post('/', 'TeachersController@updateTeacher');

            });

        Route::get('/', 'TeachersController@showAll');
    });

Route::get('/check/word', function () {
    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(base_path('Template.docx'));
    $templateProcessor->setValues([
        'studentFullName' => 'John Doe',
        'iteration' => 1,
        'studentMark' => 5,
        'excellent' => 10,
        'satisfactorily' => 10,
        'unsatisfactorily' => 10,
        'avarageMark' => 4,
        'groupName' => 'pi-172',
        'course' => '3',
        'good' => 1000,
    ]);

    $templateProcessor->saveAs('hello, word world!!!.docx');
    dd($templateProcessor);
});

Route::get('/tests/hello', function () {
    return 'tests hello' . Breadcrumbs::render('test');
})->name('.tests.test');

