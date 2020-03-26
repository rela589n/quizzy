@extends('layouts.main-skeleton', [
    'baseLayout' => 'layouts.root.admin'
])

@section('title')
    {{ $subject->name  }} - додати тест
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.tests.subject.new', $subject) }}
    @parent
@endsection

@section('main-container-content')
    @include('blocks.admin.test-form', ['submitButtonText' => 'Створити'])
@endsection

@push('bottom_scripts')
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.liTranslit.js') }}"></script>
    <script src="{{ asset('js/uri-autogenerator.js') }}"></script>
    <script src="{{ asset('js/required-if.js') }}"></script>
@endpush
