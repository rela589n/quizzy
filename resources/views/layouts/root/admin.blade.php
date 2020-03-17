@extends('layouts.root.base')

@section('body-class')
    @parent
    bg-lighter text-dark
@endsection

@section('menu')
    @include('blocks.admin.menu')
@endsection

