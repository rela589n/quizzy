@extends($baseLayout)

@section('content')
    <div class="container mt-5 categories">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                @yield('settings-link')

                @section('header')
                    <h2 class="mb-4">Існуючі тести з предмету @yield('subject-name'):</h2>
                @show

                <ul class="list-group categories text-dark">
                    @section('test-links')
                        {{--          traverse all subjects and print base layout              --}}
                    @show
                </ul>

                @yield('create-new-link')
            </div>
        </div>
    </div>
@endsection
