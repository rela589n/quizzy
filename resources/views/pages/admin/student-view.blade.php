@extends('layouts.main-skeleton', [
    'baseLayout' => 'layouts.root.admin'
])

@section('main-container-content')
    @if($authUser->can('update-students'))

        @include('blocks.admin.student-form', [
            'submitButtonText' => 'Зберегти',
            'userPasswordPlaceholder' => 'Введіть щоб змінити',
            'submitSize' => ($authUser->can('delete-students')) ? 9 : 12
        ])

        @if($authUser->can('delete-students'))
            @include('blocks.admin.delete-entity-form')
        @endif

    @else
        @include('blocks.admin.student-info')
    @endif
@endsection
