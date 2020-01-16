@extends($baseLayout)

@section('content')
    <div class="container mt-5 categories">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                @section('header')
                    <h2 class="mb-4">Існуючі предмети тестування:</h2>
                @show

                <ul class="list-group categories text-dark">
                    @section('subject-links')
{{--          traverse all subjects and print base layout              --}}
                    @show
                </ul>

                @yield('create-new-btn')
            </div>
        </div>
    </div>
@endsection
