@extends('layouts.main-skeleton', [
    'baseLayout' => 'layouts.root.admin'
])

@section('main-container-content')
    @include('blocks.admin.student-form', [
        'submitButtonText' => 'Зберегти',
        'userPasswordPlaceholder' => 'Введіть щоб змінити'
    ])
@endsection
