@extends('layouts.main-skeleton', [
    'baseLayout' => 'layouts.root.admin'
])

@section('main-container-content')
    @include('blocks.admin.teacher-form', [
        'submitButtonText' => 'Зберегти',
        'userPasswordPlaceholder' => 'Введіть щоб змінити',
        'submitSize' => 9
    ])

    @if($authUser->can('delete-administrators'))
        @include('blocks.admin.delete-entity-form')
    @endif
@endsection
