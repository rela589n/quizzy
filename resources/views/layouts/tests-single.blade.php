@extends($baseLayout)

@section('content')
    <div class="container mt-5 categories">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                @yield('settings-link')

                @section('header')
                    <h2 class="mb-4">Тест по предмету @yield('subject-name') - @yield('test-name'):</h2>
                @show
                <form method="post" class="edit-test-form mt-5">
                    @csrf
                    <ul class="list-group text-dark questions">
                        @section('test-questions')
                            {{--          traverse all subjects and print base layout              --}}
                        @show
                    </ul>

                    <div class="button-wrap text-center">
                        <button type="button" class="btn btn-primary btn-lg button-add-question"><i
                                class="fas fa-plus"></i></button>
                    </div>

                    @yield('save-button')
                </form>
            </div>
        </div>
    </div>
@endsection

@prepend('bottom_scripts')
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/test_edit.js') }}"></script>
@endprepend
