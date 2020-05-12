@extends('layouts.initial-password-change')

@section('body-class')
    @parent
    text-light
@endsection

@section('change-password-content')
    @include('layouts.blocks.change-password-form')
@endsection
