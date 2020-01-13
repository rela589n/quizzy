@extends('layouts.root.base')

@section('body-class')
    @parent
    text-light
@endsection

@section('menu')
    @include('blocks.client.menu')
@endsection

@section('content')
{{--    {{ $content }}--}}
@endsection
