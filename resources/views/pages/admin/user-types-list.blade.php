@extends('layouts.categories-list', ['baseLayout' => 'layouts.root.admin' ])

@section('category-header')
    <h2 class="mb-4">Типи користувачів:</h2>
@endsection

@section('category-links')
    @include('blocks.admin.single-user-type-line', [
        'usersType' => 'Викладачі',
        'typeUrl' => route('admin.users.teachers'),
        'usersCount' => $teachersCount
    ])

    @include('blocks.admin.single-user-type-line', [
        'usersType' => 'Студенти',
        'typeUrl' => route('admin.users.students'),
        'usersCount' => $studentsCount
    ])
@endsection
