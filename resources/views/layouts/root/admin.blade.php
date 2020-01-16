@extends('layouts.root.base')

@section('body-class')
    @parent
    bg-light text-dark
@endsection

@section('menu')
    @include('blocks.admin.menu')
@endsection

@section('content')
{{--    {{ $content }}--}}
@endsection

