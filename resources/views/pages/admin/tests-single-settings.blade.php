@extends('layouts.main-skeleton', [
    'baseLayout' => 'layouts.root.admin'
])

@section('title')
    {{ $subject->name  }} - {{ $test->name }} - налаштування
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.tests.subject.test.settings', $test, $subject) }}
    @parent
@endsection

@section('main-container-content')
    @include('blocks.admin.test-form', [
      'submitSize' => ($authUser->can('delete', $test)) ? 9 : 12
    ])

    @if($authUser->can('delete', $test))
        @include('blocks.admin.delete-entity-form')
    @endif
@endsection

@push('bottom_scripts')
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.liTranslit.js') }}"></script>
    <script src="{{ asset('js/uri-autogenerator.js') }}"></script>
    <script src="{{ asset('js/required-if.js') }}"></script>
@endpush
