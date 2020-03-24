@extends('layouts.main-skeleton', [
    'contentColumns' => 7,
    'baseLayout' => 'layouts.root.admin'
])

@section('title')
    {{ $group->name }} - налаштування
@endsection

@section('main-container-content')
    @include('blocks.admin.student-group-form', [
      'submitButtonText' => 'Зберегти',
      'submitSize' => ($authUser->can('delete-groups')) ? 9 : 12
    ])

    @if($authUser->can('delete-groups'))
        @include('blocks.admin.delete-entity-form')
    @endif
@endsection

@push('bottom_scripts')
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.liTranslit.js') }}"></script>
    <script src="{{ asset('js/uri-autogenerator.js') }}"></script>
@endpush
