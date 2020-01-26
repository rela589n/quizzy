@extends('layouts.blocks.menu')

@section('links')

    <li class="nav-item @ifroute('admin.dashboard') active @endifroute">
        <a class="nav-link" href="{{ route('admin.dashboard') }}" target="_self">Особистий кабінет</a>
    </li>

    <li class="nav-item @ifroute('admin.tests') active @endifroute">
        <a class="nav-link" href="{{ route('admin.tests') }}" target="_self">Тести</a>
    </li>

    <li class="nav-item @ifroute('admin.users') active @endifroute">
        <a class="nav-link" href="{{ route('admin.users') }}" target="_self">Користувачі</a>
    </li>

    <li class="nav-item @ifroute('admin.auth') active @endifroute">
        <a class="nav-link" href="{{ route('admin.auth') }}" target="_self">Вихід</a>
    </li>
@endsection
