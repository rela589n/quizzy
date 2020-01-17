@extends('layouts.subjects-single', ['baseLayout' => 'layouts.root.admin'])

@section('settings-link')
    <a class="btn btn-outline-dark finish-test-btn mt-1 float-right" href="{{ url()->current() }}/settings">Перейти до
        налаштувань предмета</a>
@endsection

@section('subject-name') oop @endsection

@section('test-links')
    {{--  traverse given array and print all entities  --}}

    <li class="list-group-item d-flex justify-content-between align-items-center">
        <h3 class="category-header">Інкапсуляція</h3>

        <a href="{{ url()->current() }}/encapsulation">Перейти</a>
        <span class="badge badge-primary badge-pill">50</span>
    </li>

    <li class="list-group-item d-flex justify-content-between align-items-center">
        <h3 class="category-header">Наслідування</h3>

        <a href="#">Перейти</a>
        <span class="badge badge-primary badge-pill">30</span>
    </li>

    <li class="list-group-item d-flex justify-content-between align-items-center">
        <h3 class="category-header">Поліморфізм</h3>

        <a href="#">Перейти</a>
        <span class="badge badge-primary badge-pill">40</span>
    </li>
@endsection

@section('create-new-link')
    <a class="btn btn-primary finish-test-btn mt-4 btn-block" href="{{ url()->current() }}/new">Новий</a>
@endsection
