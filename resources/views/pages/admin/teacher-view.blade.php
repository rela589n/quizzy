@extends('layouts.main-skeleton', [
    'baseLayout' => 'layouts.root.admin'
])

@section('title')
    {{ $user->full_name }}
@endsection

@section('main-container-content')
    @if($authUser->can('update-administrators'))

        @include('blocks.admin.teacher-form', [
            'submitButtonText' => 'Зберегти',
            'userPasswordPlaceholder' => 'Введіть щоб змінити',
            'submitSize' => ($authUser->can('delete-administrators')) ? 9 : 12
        ])

        @if($authUser->can('delete-administrators'))
            @include('blocks.admin.delete-entity-form')
        @endif

    @else
        @include('blocks.admin.teacher-info')
    @endif

@endsection
