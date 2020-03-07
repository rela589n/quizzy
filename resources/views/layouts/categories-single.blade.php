@extends('layouts.main-skeleton', [
    'baseLayout' => $baseLayout
])

@section('main-container-class')
    @parent
    categories
@endsection

@section('main-container-content')
    @yield('category-settings-link')

    @section('category-header')
        <h2 class="mb-4">@yield('category-header-text')</h2>
    @show

    @section('category-main-content')
        <ul class="list-group categories text-dark">
            @yield('category-links')
        </ul>
    @show

    @yield('category-new-btn')
@endsection
