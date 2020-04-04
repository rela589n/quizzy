@extends($baseLayout)

@section('title')
    Особистий кабінет
@endsection

@section('content')
    <div class="container dashboard">
        <div class="row">
            <div class="col-12">
                <header class="text-center mt-4">
                    @section('headings')
                        <h1>Ласкаво просимо!</h1>
                        <h4>ви в персональному кабінеті</h4>
                    @show
                </header>

                @yield('dashboard-content')
            </div>
        </div>
    </div>
@endsection
