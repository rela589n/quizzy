@extends('layouts.main-skeleton', [
    'contentColumns' => 7,
    'baseLayout' => 'layouts.root.admin'
])

@section('title')
    Створити групу студентів
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.students.new') }}
    @parent
@endsection

@section('main-container-content')
    @include('blocks.admin.student-group-form')
@endsection

@push('bottom_scripts')
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.liTranslit.js') }}"></script>
    <script src="{{ asset('js/uri-autogenerator.js') }}"></script>
@endpush
