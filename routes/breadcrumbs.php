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
use App\Models\Department;
use App\Models\StudentGroup;
use App\Models\Test;
use App\Models\TestSubject;
use App\Models\User;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::for(
    'admin.tests',
    static function (BreadcrumbsGenerator $trail) {
        $trail->push('Предмети тестування', route('admin.tests'));
    }
);

Breadcrumbs::for(
    'admin.tests.new',
    static function (BreadcrumbsGenerator $trail) {
        $trail->parent('admin.tests');
        $trail->push('Створити новий', route('admin.tests.new'));
    }
);

Breadcrumbs::for(
    'admin.tests.subject',
    static function (BreadcrumbsGenerator $trail, TestSubject $subject) {
        $trail->parent('admin.tests');
        $trail->push($subject->name, route('admin.tests.subject', ['subject' => $subject->uri_alias]));
    }
);

Breadcrumbs::for(
    'admin.tests.subject.settings',
    static function (BreadcrumbsGenerator $trail, TestSubject $subject) {
        $trail->parent('admin.tests.subject', $subject);
        $trail->push(
            'Налаштування',
            route(
                'admin.tests.subject.settings',
                [
                    'subject' => $subject->uri_alias
                ]
            )
        );
    }
);

Breadcrumbs::for(
    'admin.tests.subject.new',
    static function (BreadcrumbsGenerator $trail, TestSubject $subject) {
        $trail->parent('admin.tests.subject', $subject);
        $trail->push('Створити тест', route('admin.tests.subject.new', ['subject' => $subject->uri_alias]));
    }
);

Breadcrumbs::for(
    'admin.tests.subject.test',
    static function (BreadcrumbsGenerator $trail, Test $test, TestSubject $subject = null) {
        $trail->parent('admin.tests.subject', $subject ?? $test->subject);

        $trail->push(
            $test->name,
            route(
                'admin.tests.subject.test',
                [
                    'subject' => $subject->uri_alias ?? $test->subject->uri_alias,
                    'test'    => $test->uri_alias,
                ]
            )
        );
    }
);

Breadcrumbs::for(
    'admin.tests.subject.test.settings',
    static function (BreadcrumbsGenerator $trail, Test $test, TestSubject $subject = null) {
        $trail->parent('admin.tests.subject.test', $test, $subject);
        $trail->push(
            'Налаштування',
            route(
                'admin.tests.subject.test.settings',
                [
                    'subject' => $subject->uri_alias ?? $test->subject->uri_alias,
                    'test'    => $test->uri_alias,
                ]
            )
        );
    }
);

Breadcrumbs::for(
    'admin.tests.subject.test.transfer',
    static function (BreadcrumbsGenerator $trail, Test $test, TestSubject $subject = null) {
        $trail->parent('admin.tests.subject.test', $test, $subject);

        $trail->push(
            'Імпорт',
            route(
                'admin.tests.subject.test.transfer',
                [
                    'subject' => $subject->uri_alias ?? $test->subject->uri_alias,
                    'test'    => $test->uri_alias,
                ]
            )
        );
    }
);

Breadcrumbs::for(
    'admin.results',
    static function (BreadcrumbsGenerator $trail) {
        $trail->push('Вибір предмета', route('admin.results'));
    }
);

Breadcrumbs::for(
    'admin.results.subject',
    static function (BreadcrumbsGenerator $trail, TestSubject $subject) {
        $trail->parent('admin.results');
        $trail->push(
            $subject->name,
            route(
                'admin.results.subject',
                [
                    'subject' => $subject->uri_alias
                ]
            )
        );
    }
);

Breadcrumbs::for(
    'admin.results.subject.test',
    static function (BreadcrumbsGenerator $trail, Test $test, TestSubject $subject = null) {
        $trail->parent('admin.results.subject', $subject ?? $test->subject);

        $trail->push(
            $test->name,
            route(
                'admin.results.subject.test',
                [
                    'subject' => $subject->uri_alias ?? $test->subject->uri_alias,
                    'test'    => $test->uri_alias
                ]
            )
        );
    }
);

Breadcrumbs::for(
    'admin.students',
    static function (BreadcrumbsGenerator $trail) {
        $trail->push('Список відділень', route('admin.students'));
    }
);

Breadcrumbs::for(
    'admin.students.new',
    static function (BreadcrumbsGenerator $trail) {
        $trail->parent('admin.students');
        $trail->push('Створити відділення', route('admin.students.new'));
    }
);


Breadcrumbs::for(
    'admin.students.department',
    static function (BreadcrumbsGenerator $trail, Department $department) {
        $trail->parent('admin.students');

        $trail->push(
            $department->name,
            route(
                'admin.students.department',
                [
                    'department' => $department->uri_alias
                ]
            )
        );
    }
);

Breadcrumbs::for(
    'admin.students.department.new',
    static function (BreadcrumbsGenerator $trail, Department $department) {
        $trail->parent('admin.students.department', $department);

        $trail->push(
            'Створити групу',
            route(
                'admin.students.department.new',
                [
                    'department' => $department->uri_alias
                ]
            )
        );
    }
);

Breadcrumbs::for(
    'admin.students.department.settings',
    static function (BreadcrumbsGenerator $trail, Department $department) {
        $trail->parent('admin.students.department', $department);

        $trail->push(
            'Налаштування',
            route(
                'admin.students.department.settings',
                [
                    'department' => $department->uri_alias
                ]
            )
        );
    }
);


Breadcrumbs::for(
    'admin.students.department.group',
    static function (BreadcrumbsGenerator $trail, Department $department, StudentGroup $group) {
        $trail->parent('admin.students.department', $department);
        $trail->push(
            $group->name,
            route(
                'admin.students.department.group',
                [
                    'department' => $department->uri_alias,
                    'group'      => $group->uri_alias
                ]
            )
        );
    }
);

Breadcrumbs::for(
    'admin.students.department.group.settings',
    static function (BreadcrumbsGenerator $trail, Department $department, StudentGroup $group) {
        $trail->parent('admin.students.department.group', $department, $group);

        $trail->push(
            'Налаштування',
            route(
                'admin.students.department.group.settings',
                [
                    'department' => $department->uri_alias,
                    'group'      => $group->uri_alias
                ]
            )
        );
    }
);

Breadcrumbs::for(
    'admin.students.department.group.new',
    static function (BreadcrumbsGenerator $trail, Department $department, StudentGroup $group) {
        $trail->parent('admin.students.department.group', $department, $group);

        $trail->push(
            'Додати студента',
            route(
                'admin.students.department.group.new',
                [
                    'department' => $department->uri_alias,
                    'group'      => $group->uri_alias
                ]
            )
        );
    }
);

Breadcrumbs::for(
    'admin.students.department.group.student',
    static function (
        BreadcrumbsGenerator $trail,
        User $student,
        StudentGroup $group = null,
        Department $department = null
    ) {
        $group = $group ?? $student->studentGroup;
        $department = $department ?? $group->department;

        $trail->parent('admin.students.department.group', $department, $group);

        $trail->push(
            $student->full_name,
            route(
                'admin.students.department.group.student',
                [
                    'department' => $department->uri_alias,
                    'group'      => $group->uri_alias,
                    'studentId'  => $student->id
                ]
            )
        );
    }
);

Breadcrumbs::for(
    'admin.teachers',
    static function (BreadcrumbsGenerator $trail) {
        $trail->push('Список адміністраторів', route('admin.teachers'));
    }
);

Breadcrumbs::for(
    'admin.teachers.new',
    static function (BreadcrumbsGenerator $trail) {
        $trail->parent('admin.teachers');
        $trail->push('Додати нового', route('admin.teachers.new'));
    }
);

Breadcrumbs::for(
    'admin.teachers.teacher',
    static function (BreadcrumbsGenerator $trail, Administrator $user) {
        $trail->parent('admin.teachers');
        $trail->push(
            $user->full_name,
            route(
                'admin.teachers.teacher',
                [
                    'teacherId' => $user->id
                ]
            )
        );
    }
);
