@extends('layouts.categories-list', ['baseLayout' => 'layouts.root.client' ])

@section('header')
    <h2 class="mb-4">Усі доступні предмети тестування:</h2>
@endsection

@section('subject-links')
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <h3 class="category-header">ООП</h3>

        <a href="#">Перейти</a>
        <span class="badge badge-primary badge-pill">4</span>
    </li>

    <li class="list-group-item d-flex justify-content-between align-items-center">
        <h3 class="category-header">Алгоритми</h3>

        <a href="#">Перейти</a>
        <span class="badge badge-primary badge-pill">5</span>
    </li>

    <li class="list-group-item d-flex justify-content-between align-items-center">
        <h3 class="category-header">Вступ до інженерії програмного забезпечення</h3>

        <a href="#">Перейти</a>
        <span class="badge badge-primary badge-pill">1</span>
    </li>
@endsection
