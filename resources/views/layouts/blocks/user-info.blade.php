@section('user-info-table')
    @section('info-header')
        <h3 class="mb-4">Інформація про користувача:</h3>
    @show

    <table class="table">
        @include('blocks.info-row', [
            'key' => 'Прізвище:',
            'val' => $user->surname
        ])
        @include('blocks.info-row', [
            'key' => 'Ім\'я:',
            'val' => $user->name
        ])
        @include('blocks.info-row', [
            'key' => 'По-батькові:',
            'val' => $user->patronymic
        ])
        @include('blocks.info-row', [
            'key' => 'Логін (email):',
            'val' => $user->email
        ])

        @yield('user-info-additions')
    </table>
@show
