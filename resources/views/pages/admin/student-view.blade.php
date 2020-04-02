@extends('layouts.main-skeleton', [
    'baseLayout' => 'layouts.root.admin'
])

@section('title')
    {{ $user->studentGroup->name }} - {{ $user->full_name }}
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.students.group.student', $user) }}
    @parent
@endsection

@section('main-container-content')
    @if($authUser->can('update-students'))

        @include('blocks.admin.student-form', [
            'submitButtonText' => 'Зберегти',
            'userPasswordPlaceholder' => 'Введіть щоб змінити',
            'submitSize' => ($authUser->can('delete', $user)) ? 9 : 12
        ])

        @if($authUser->can('delete', $user))
            @include('blocks.admin.delete-entity-form')
        @endif

    @else
        @include('blocks.admin.student-info')
    @endif
@endsection
