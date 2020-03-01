@extends($baseLayout)

@section('content')
    <div class="container mt-5 categories">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                @yield('category-settings-link')

                @section('header')
                    <h2 class="mb-4">@yield('header-text')</h2>
                @show

                <ul class="list-group categories text-dark">
                    @yield('category-links')
                </ul>

                @yield('create-new-link')
            </div>
        </div>
    </div>
@endsection
