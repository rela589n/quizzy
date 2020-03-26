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

Breadcrumbs::for('admin.tests',
    function (\DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $trail) {
        $trail->push('Предмети тестування', route('admin.tests'));
    });

Breadcrumbs::for('admin.tests.subject',
    function (\DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $trail, $subject) {
        $trail->parent('admin.tests');
        $trail->push($subject->name, route('admin.tests.subject', ['subject' => $subject->uri_alias]));
    });

Breadcrumbs::for('admin.tests.subject.settings',
    function (\DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $trail, $subject) {
        $trail->parent('admin.tests.subject', $subject);
        $trail->push('Налаштування', route(
                'admin.tests.subject.settings',
                [
                    'subject' => $subject->uri_alias
                ])
        );
    });


Breadcrumbs::for('admin.tests.subject.test',
    function (\DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $trail, $test, $subject = null) {
        $trail->parent('admin.tests.subject', $subject ?? $test->subject);

        $trail->push($test->name, route(
                'admin.tests.subject.test',
                [
                    'subject' => $subject->uri_alias ?? $test->subject->uri_alias,
                    'test' => $test->uri_alias,
                ])
        );
    });

Breadcrumbs::for('admin.tests.subject.test.settings',
    function (\DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $trail, $test, $subject = null) {
        $trail->parent('admin.tests.subject.test', $test, $subject);
        $trail->push('Налаштування', route(
                'admin.tests.subject.test.settings',
                [
                    'subject' => $subject->uri_alias ?? $test->subject->uri_alias,
                    'test' => $test->uri_alias,
                ])
        );
    });

Breadcrumbs::for('admin.results',
    function (\DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $trail) {
        $trail->push('Вибір предмета', route('admin.results'));
    });

Breadcrumbs::for('admin.results.subject',
    function (\DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $trail, $subject) {
        $trail->parent('admin.results');
        $trail->push($subject->name, route(
            'admin.results.subject',
            [
                'subject' => $subject->uri_alias
            ]
        ));
    });

Breadcrumbs::for('admin.results.subject.test',
    function (\DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $trail, $test, $subject = null) {

        $trail->parent('admin.results.subject', $subject ?? $test->subject);

        $trail->push($test->name, route(
            'admin.results.subject.test',
            [
                'subject' => $subject->uri_alias ?? $test->subject->uri_alias,
                'test' => $test->uri_alias
            ]
        ));
    });


