@extends('layouts.blocks.menu')

@section('menu-container-type')
    container-fluid
@endsection

@section('links')

    <li class="nav-item @ifroute('admin.dashboard') active @endifroute">
        <a class="nav-link" href="{{ route('admin.dashboard') }}" target="_self">Особистий кабінет</a>
    </li>

    @if ($authUser->can('access-subjects'))
        <li class="nav-item @ifroute('admin.tests') active @endifroute">
            <a class="nav-link" href="{{ route('admin.tests') }}" target="_self">Тестування</a>
        </li>
    @endif

    @if($authUser->can('view-results'))
        <li class="nav-item @ifroute('admin.results') active @endifroute">
            <a class="nav-link" href="{{ route('admin.results') }}" target="_self">Результати</a>
        </li>
    @endif

    @if ($authUser->can('access-administrators'))
        <li class="nav-item @ifroute('admin.teachers') active @endifroute">
            <a class="nav-link" href="{{ route('admin.teachers') }}" target="_self">Адміністратори</a>
        </li>
    @endif

    @if ($authUser->can('access-groups'))
        <li class="nav-item @ifroute('admin.students') active @endifroute">
            <a class="nav-link" href="{{ route('admin.students') }}" target="_self">Студенти</a>
        </li>
    @endif

    <li class="nav-item @ifroute('admin.logout') active @endifroute">
        <a class="nav-link" href="{{ route('admin.logout') }}" target="_self"
           onclick="event.preventDefault(); document.getElementById('admin-logout-post-form').submit();">Вихід</a>
        <form id="admin-logout-post-form" action="{{ route('admin.logout') }}" method="post" style="display: none;">
            @csrf
        </form>
    </li>
@endsection
