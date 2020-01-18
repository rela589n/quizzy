@extends('layouts.categories-list', ['baseLayout' => 'layouts.root.admin' ])

@section('header')
    <h2 class="mb-4">Існуючі категорії користувачів:</h2>
@endsection

@section('subject-links')
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <h3 class="category-header">Адміністратори</h3>

        <a href="{{ url()->current() }}/administrators">Перейти</a>
        <span class="badge badge-primary badge-pill">1</span>
    </li>

    <li class="list-group-item d-flex justify-content-between align-items-center">
        <h3 class="category-header">Викладачі</h3>

        <a href="{{ url()->current() }}/teachers">Перейти</a>
        <span class="badge badge-primary badge-pill">3</span>
    </li>

    <li class="list-group-item d-flex justify-content-between align-items-center">
        <h3 class="category-header">Студенти</h3>

        <a href="{{ url()->current() }}/students">Перейти</a>
        <span class="badge badge-primary badge-pill">40</span>
    </li>
@endsection
