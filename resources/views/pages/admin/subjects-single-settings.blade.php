@extends('layouts.main-skeleton', [
    'contentColumns' => 7,
    'baseLayout' => 'layouts.root.admin'
])

@section('main-container-content')
    @include('blocks.admin.subject-form', [
        'submitButtonText' => 'Зберегти',
        'submitSize' => ($authUser->can('delete-subjects')) ? 9 : 12
    ])

    @if($authUser->can('delete-subjects'))
        @include('blocks.admin.delete-entity-form')
    @endif

@endsection

@push('bottom_scripts')
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.liTranslit.js') }}"></script>
    <script src="{{ asset('js/uri-autogenerator.js') }}"></script>
@endpush
