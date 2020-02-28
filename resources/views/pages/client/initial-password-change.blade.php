@extends('layouts.root.base')

@section('body-class')
    @parent
    auth
    text-light
@endsection

@section('content')
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-4"></div>
            <div class="col-4 mtb-auto">
                @include('layouts.blocks.change-password-form')
            </div>
        </div>
    </div>
@endsection
