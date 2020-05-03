@extends('layouts.blocks.menu')

@section('menu-container-type')
    container
@endsection

@section('links')
    <li class="nav-item @ifroute('client.dashboard') active @endifroute">
        <a class="nav-link" href="{{ route('client.dashboard') }}" target="_self">Особистий
            кабінет</a>
    </li>
    <li class="nav-item @ifroute('client.tests') active @endifroute">
        <a class="nav-link" href="{{ route('client.tests') }}" target="_self">Тестування</a>
    </li>
    <li class="nav-item @ifroute('client.logout') active @endifroute">
        <a class="nav-link logout-link" href="{{ route('client.logout') }}" target="_self" onclick="event.preventDefault(); document.getElementById('client-logout-post-form').submit();">Вихід</a>
        <form id="client-logout-post-form" action="{{ route('client.logout') }}" method="post" style="display: none;">
            @csrf
        </form>
    </li>
@endsection
