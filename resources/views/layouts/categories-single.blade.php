@extends($baseLayout)

@section('content')
    <div class="@section('category-class') container mt-5 categories @show">
        <div class="row">
            <div class="col-{{ (12 - ($contentColumns ?? 8)) >> 1 }}"></div>
            <div class="col-{{ $contentColumns ?? 8 }}">
                @yield('category-settings-link')

                @section('category-header')
                    <h2 class="mb-4">@yield('category-header-text')</h2>
                @show

                @section('category-main-content')
                    <ul class="list-group categories text-dark">
                        @yield('category-links')
                    </ul>
                @show

                @yield('create-new-link')
            </div>
        </div>
    </div>
@endsection
