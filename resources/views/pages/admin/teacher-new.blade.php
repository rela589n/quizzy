@extends('layouts.root.admin')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                @section('user-form-group') @endsection
                @include('blocks.admin.teacher-form')
            </div>
        </div>
    </div>
@endsection
