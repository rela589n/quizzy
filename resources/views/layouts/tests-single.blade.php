@extends('layouts.categories-single', [
    'baseLayout' => $baseLayout,
    'contentColumns' => 10
])

@section('head_styles')
    <link href="{{ asset('css/vendor/froala_styles.min.css') }}" rel="stylesheet" type="text/css" />
    @parent
@endsection

@section('category-main-content')
    <form method="post" action="{{ $passTestAction ?? '' }}" data-finish-action="{{ $finishTestAction ?? '' }}" class="edit-test-form mt-5">
        @csrf
        <ul class="list-group text-dark questions">
            @yield('test-questions')
        </ul>

        @yield('additions')
        @yield('save-button')
    </form>
@endsection
