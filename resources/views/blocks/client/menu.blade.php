@extends('layouts.menu')

@section('links')
    <li class="nav-item @ifroute('client.dashboard') active @endifroute">
        <a class="nav-link" href="{{ route('client.dashboard') }}" target="_self">Особистий
            кабінет</a>
    </li>
    <li class="nav-item @ifroute('client.tests') active @endifroute">
        <a class="nav-link" href="{{ route('client.tests') }}" target="_self">Тестування</a>
    </li>
    <li class="nav-item @ifroute('client.auth') active @endifroute">
        <a class="nav-link" href="{{ route('client.auth') }}" target="_self">Вихід</a>
    </li>
@endsection
