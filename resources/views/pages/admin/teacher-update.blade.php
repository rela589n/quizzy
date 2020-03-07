@extends('layouts.main-skeleton', [
    'baseLayout' => 'layouts.root.admin'
])

@section('main-container-content')
    @include('blocks.admin.teacher-form', [
        'submitButtonText' => 'Зберегти',
        'userPasswordPlaceholder' => 'Введіть щоб змінити'
    ])
@endsection
