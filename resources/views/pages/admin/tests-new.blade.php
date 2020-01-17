@extends('layouts.root.admin')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                @include('blocks.admin.test-form', ['submitButtonText' => 'Створити'])
            </div>
        </div>
    </div>
@endsection

@push('bottom_scripts')

@endpush
