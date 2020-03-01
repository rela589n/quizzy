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

    <li class="nav-item @ifroute('admin.students') active @endifroute">
        <a class="nav-link" href="{{ route('admin.students') }}" target="_self">Студенти</a>
    </li>

    <li class="nav-item @ifroute('admin.logout') active @endifroute">
        <a class="nav-link" href="{{ route('admin.logout') }}" target="_self" onclick="event.preventDefault(); document.getElementById('admin-logout-post-form').submit();">Вихід</a>
        <form id="admin-logout-post-form" action="{{ route('admin.logout') }}" method="post" style="display: none;">
            @csrf
        </form>
    </li>
@endsection
