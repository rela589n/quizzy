@extends('layouts.main-skeleton', [
    'baseLayout' => 'layouts.root.admin'
])

@section('main-container-content')
    @include('blocks.admin.test-form', ['submitButtonText' => 'Зберегти'])
@endsection

@push('bottom_scripts')
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.liTranslit.js') }}"></script>
    <script src="{{ asset('js/uri-autogenerator.js') }}"></script>
    <script src="{{ asset('js/required-if.js') }}"></script>
@endpush
