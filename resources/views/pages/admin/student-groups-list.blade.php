@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.admin' ])

@section('title')
    Групи студентів
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.students') }}
    @parent
@endsection

@section('category-header-text')
    Список доступних груп студентів:
@endsection

@section('category-links')
    @forelse($groups as $group)
        @include('blocks.entity-line', [
            'header' => $group->name,
            'link' => route('admin.students.group', ['group' => $group['uri_alias'] ]),
            'badge' => $group->students_count,
        ])
    @empty
        @component('layouts.blocks.empty-list-message')
            Немає жодної групи
        @endcomponent
    @endforelse
@endsection


@section('category-new-btn')
    @if ($authUser->can('create-groups'))
        @include('blocks.admin.create-new-link', [
            'link' => route('admin.students.new'),
            'text' => 'Створити групу'
        ])
    @endif
@endsection

@include('blocks.scripts.no-scripts')
