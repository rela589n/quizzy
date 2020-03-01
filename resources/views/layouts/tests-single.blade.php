@extends('layouts.categories-single', [
    'baseLayout' => $baseLayout,
    'contentColumns' => 10
])

@section('category-main-content')
    <form method="post" class="edit-test-form mt-5">
        @csrf
        <ul class="list-group text-dark questions">
            @yield('test-questions')
        </ul>

        @yield('additions')
        @yield('save-button')
    </form>
@endsection

@prepend('bottom_scripts')
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
@endprepend
