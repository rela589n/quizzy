@extends('layouts.root.admin')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-7">
                @include('blocks.admin.subject-form', ['submitButtonText' => 'Зберегти'])
            </div>
        </div>
    </div>
@endsection

@push('bottom_scripts')
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.liTranslit.js') }}"></script>
    <script src="{{ asset('js/subject-form.js') }}"></script>
@endpush
