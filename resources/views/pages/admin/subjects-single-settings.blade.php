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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
@endpush
