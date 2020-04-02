@extends('layouts.main-skeleton', [
    'baseLayout' => 'layouts.root.admin'
])

@section('title')
    {{ $user->full_name }}
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.teachers.teacher', $user) }}
    @parent
@endsection

@section('main-container-content')
    @if($authUser->can('update', $user))

        @include('blocks.admin.teacher-form', [
            'submitButtonText' => 'Зберегти',
            'userPasswordPlaceholder' => 'Введіть щоб змінити',
            'submitSize' => ($authUser->can('delete', $user)) ? 9 : 12
        ])

        @if($authUser->can('delete', $user))
            @include('blocks.admin.delete-entity-form')
        @endif

    @else
        @include('blocks.admin.teacher-info')
    @endif

@endsection
