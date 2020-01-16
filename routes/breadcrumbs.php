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

// Home
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::for('admin.tests', function (BreadcrumbsGenerator $trail) {
    $trail->push('first', route('admin.tests'));
});

Breadcrumbs::for('test', function (BreadcrumbsGenerator $trail) {
    $trail->parent('admin.tests');
    $trail->push('second', route('admin.tests.test'));
});
