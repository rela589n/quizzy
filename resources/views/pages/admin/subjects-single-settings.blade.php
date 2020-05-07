@extends('layouts.main-skeleton', [
    'contentColumns' => 7,
    'baseLayout' => 'layouts.root.admin'
])

@section('title')
    {{ $subject->name  }} - налаштування
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.tests.subject.settings', $subject) }}
    @parent
@endsection

@section('main-container-content')
    @include('blocks.admin.subject-form', [
        'submitButtonText' => 'Зберегти',
        'submitSize' => ($authUser->can('delete', $subject)) ? 9 : 12
    ])

    @if($authUser->can('delete', $subject))
        @include('blocks.admin.delete-entity-form')
    @endif
@endsection
