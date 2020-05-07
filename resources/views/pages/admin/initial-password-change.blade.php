@extends('layouts.initial-password-change')

@section('body-class')
    @parent
    bg-lighter
@endsection

@section('change-password-content')
    @include('layouts.blocks.change-password-form')
@endsection

@include('blocks.scripts.no-scripts')
