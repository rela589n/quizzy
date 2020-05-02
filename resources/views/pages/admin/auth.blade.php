@extends('layouts.auth')

@section('title')
    Адмін-панель - Аутентифікація
@endsection

@section('body-class')
    @parent
    bg-lighter
@endsection

@section('form-class')
    @parent
    text-dark
@endsection

@section('auth-form-header')
    <h2>Вхід в адмін-панель:</h2>
@endsection
