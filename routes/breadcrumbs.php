<?php
/*
|--------------------------------------------------------------------------
| Breadcrumbs
|--------------------------------------------------------------------------
|
| Here is where you can register and bind breadcrumbs for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group and prefixed with '/admin'.
| Now create something great!
|
*/

use App\Models\Administrator;
use App\Models\StudentGroup;
use App\Models\Test;
use App\Models\TestSubject;
use App\Models\User;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::for('admin.tests',
    function (BreadcrumbsGenerator $trail) {
        $trail->push('Предмети тестування', route('admin.tests'));
    });

Breadcrumbs::for('admin.tests.new',
    function (BreadcrumbsGenerator $trail) {
        $trail->parent('admin.tests');
        $trail->push('Створити новий', route('admin.tests.new'));
    });

Breadcrumbs::for('admin.tests.subject',
    function (BreadcrumbsGenerator $trail, TestSubject $subject) {
        $trail->parent('admin.tests');
        $trail->push($subject->name, route('admin.tests.subject', ['subject' => $subject->uri_alias]));
    });

Breadcrumbs::for('admin.tests.subject.settings',
    function (BreadcrumbsGenerator $trail, TestSubject $subject) {
        $trail->parent('admin.tests.subject', $subject);
        $trail->push('Налаштування', route(
                'admin.tests.subject.settings',
                [
                    'subject' => $subject->uri_alias
                ])
        );
    });

Breadcrumbs::for('admin.tests.subject.new',
    function (BreadcrumbsGenerator $trail, TestSubject $subject) {
        $trail->parent('admin.tests.subject', $subject);
        $trail->push('Створити тест', route('admin.tests.subject.new', ['subject' => $subject->uri_alias]));
    });

Breadcrumbs::for('admin.tests.subject.test',
    function (BreadcrumbsGenerator $trail, Test $test, TestSubject $subject = null) {
        $trail->parent('admin.tests.subject', $subject ?? $test->subject);

        $trail->push($test->name, route(
                'admin.tests.subject.test',
                [
                    'subject' => $subject->uri_alias ?? $test->subject->uri_alias,
                    'test'    => $test->uri_alias,
                ])
        );
    });

Breadcrumbs::for('admin.tests.subject.test.settings',
    function (BreadcrumbsGenerator $trail, Test $test, TestSubject $subject = null) {
        $trail->parent('admin.tests.subject.test', $test, $subject);
        $trail->push('Налаштування', route(
                'admin.tests.subject.test.settings',
                [
                    'subject' => $subject->uri_alias ?? $test->subject->uri_alias,
                    'test'    => $test->uri_alias,
                ])
        );
    });

Breadcrumbs::for('admin.tests.subject.test.transfer',
    function (BreadcrumbsGenerator $trail, Test $test, TestSubject $subject = null) {
        $trail->parent('admin.tests.subject.test', $test, $subject);

        $trail->push('Імпорт', route(
                'admin.tests.subject.test.transfer',
                [
                    'subject' => $subject->uri_alias ?? $test->subject->uri_alias,
                    'test'    => $test->uri_alias,
                ])
        );
    });

Breadcrumbs::for('admin.results',
    function (BreadcrumbsGenerator $trail) {
        $trail->push('Вибір предмета', route('admin.results'));
    });

Breadcrumbs::for('admin.results.subject',
    function (BreadcrumbsGenerator $trail, TestSubject $subject) {
        $trail->parent('admin.results');
        $trail->push($subject->name, route(
            'admin.results.subject',
            [
                'subject' => $subject->uri_alias
            ]
        ));
    });

Breadcrumbs::for('admin.results.subject.test',
    function (BreadcrumbsGenerator $trail, Test $test, TestSubject $subject = null) {

        $trail->parent('admin.results.subject', $subject ?? $test->subject);

        $trail->push($test->name, route(
            'admin.results.subject.test',
            [
                'subject' => $subject->uri_alias ?? $test->subject->uri_alias,
                'test'    => $test->uri_alias
            ]
        ));
    });

Breadcrumbs::for('admin.students',
    function (BreadcrumbsGenerator $trail) {
        $trail->push('Список груп студентів', route('admin.students'));
    });

Breadcrumbs::for('admin.students.new',
    function (BreadcrumbsGenerator $trail) {
        $trail->parent('admin.students');
        $trail->push('Створити групу', route('admin.students.new'));
    });

Breadcrumbs::for('admin.students.group',
    function (BreadcrumbsGenerator $trail, StudentGroup $group) {

        $trail->parent('admin.students');
        $trail->push($group->name, route(
            'admin.students.group',
            [
                'group' => $group->uri_alias
            ]
        ));
    });

Breadcrumbs::for('admin.students.group.new',
    function (BreadcrumbsGenerator $trail, StudentGroup $group) {
        $trail->parent('admin.students.group', $group);
        $trail->push('Додати студента', route(
            'admin.students.group.new',
            [
                'group' => $group->uri_alias
            ]
        ));
    });

Breadcrumbs::for('admin.students.group.settings',
    function (BreadcrumbsGenerator $trail, StudentGroup $group) {
        $trail->parent('admin.students.group', $group);
        $trail->push('Налаштування', route(
            'admin.students.group.settings',
            [
                'group' => $group->uri_alias
            ]
        ));
    });

Breadcrumbs::for('admin.students.group.student',
    function (BreadcrumbsGenerator $trail, User $student, StudentGroup $group = null) {

        $trail->parent('admin.students.group', $group ?? $student->studentGroup);
        $trail->push($student->full_name, route(
            'admin.students.group.student',
            [
                'group'     => $group->uri_alias ?? $student->studentGroup->uri_alias,
                'studentId' => $student->id
            ]
        ));
    });

Breadcrumbs::for('admin.teachers',
    function (BreadcrumbsGenerator $trail) {
        $trail->push('Список адміністраторів', route('admin.teachers'));
    });

Breadcrumbs::for('admin.teachers.new',
    function (BreadcrumbsGenerator $trail) {
        $trail->parent('admin.teachers');
        $trail->push('Додати нового', route('admin.teachers.new'));
    });

Breadcrumbs::for('admin.teachers.teacher',
    function (BreadcrumbsGenerator $trail, Administrator $user) {
        $trail->parent('admin.teachers');
        $trail->push($user->full_name, route('admin.teachers.teacher', [
            'teacherId' => $user->id
        ]));
    });
