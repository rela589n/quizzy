@extends('layouts.categories-single', [
    'baseLayout' => $baseLayout,
    'contentColumns' => 8
])

@section('category-main-content')
    <form method="post" class="edit-test-form" enctype="multipart/form-data">
        @csrf

        @yield('transfer-form-content')
    </form>
@endsection
