@extends('layouts.categories-list', ['baseLayout' => 'layouts.root.admin' ])

@section('header')
    <h2 class="mb-4">Усі доступні предмети тестування:</h2>
@endsection

@section('subject-links')
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <h3 class="category-header">ООП</h3>

        <a href="{{ route('admin.tests.subject', ['subject' => 'oop']) }}">Перейти</a>
        <span class="badge badge-primary badge-pill">4</span>
    </li>

    @foreach($subjects as $subject)
        @include('blocks.admin.subject-line', ['subject' => $subject])
    @endforeach
@endsection

@section('create-new-btn')
    @include('blocks.admin.create-new-link', [
        'link' => route('admin.tests.new')
    ])
@endsection
