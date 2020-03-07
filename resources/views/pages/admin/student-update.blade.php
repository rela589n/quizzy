@extends('layouts.main-skeleton', [
    'baseLayout' => 'layouts.root.admin'
])

@section('main-container-content')
    @include('blocks.admin.student-form', [
        'submitButtonText' => 'Зберегти',
        'userPasswordPlaceholder' => 'Введіть щоб змінити',
        'submitSize' => 9,
    ])
    @include('blocks.admin.delete-entity-form')
@endsection
