@extends('layouts.root.base')

@section('body-class')
    @parent
    bg-light text-dark
@endsection

@section('menu')
    @include('menu.')
@endsection

@section('content')
{{--    {{ $content }}--}}
@endsection

{{--@section('title')--}}
{{--    123--}}
{{--@endsection--}}
