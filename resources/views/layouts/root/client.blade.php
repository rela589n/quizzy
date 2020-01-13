@extends('layouts.root.base')

@section('body-class')
    @parent
    text-light
@endsection

@section('menu')
    @include('menu.client')
@endsection

@section('content')
{{--    {{ $content }}--}}
@endsection

{{--@section('title')--}}
{{--    123--}}
{{--@endsection--}}
