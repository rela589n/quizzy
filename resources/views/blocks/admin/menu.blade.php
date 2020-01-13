@extends('layouts.menu')

@section('links')
    <li class="nav-item active">
        <a class="nav-link @ifroute('dashboard') active @endifroute" href="{{ route('client.dashboard') }}" target="_self">Особистий
            кабінет</a>
    </li>
    <li class="nav-item">
        <a class="nav-link @ifroute('tests') active @endifroute" href="tests.html" target="_self">Тестування</a>
    </li>
    <li class="nav-item @ifroute('auth') active @endifroute">
        <a class="nav-link" href="auth.html" target="_self">Вихід</a>
    </li>
@endsection
