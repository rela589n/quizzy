@extends($baseLayout)

@section('content')
    <div class="@section('main-container-class') container mt-5 @show">
        <div class="row">
            <div class="col-{{ (12 - ($contentColumns ?? 8)) >> 1 }}"></div>
            <div class="col-{{ $contentColumns ?? 8 }}">
                @yield('main-container-content')
            </div>
        </div>
    </div>
@endsection
