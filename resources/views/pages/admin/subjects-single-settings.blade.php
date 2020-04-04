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

@push('bottom_scripts')
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.liTranslit.js') }}"></script>
    <script src="{{ asset('js/uri-autogenerator.js') }}"></script>
@endpush
