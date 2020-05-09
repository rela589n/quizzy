@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.admin' ])

@section('title')
    Групи відділення "{{ $department->name }}"
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.students.department', $department) }}
    @parent
@endsection

@section('category-header-text')
    Список доступних груп студентів:
@endsection

@section('category-settings-link')
    @if($authUser->can('update', $department))
        @include('blocks.admin.settings-link', [
            'link' => route('admin.students.settings', ['group' => $department->uri_alias]),
            'text' => 'Перейти до налаштувань відділення'
        ])
    @endif
@endsection

@section('category-links')
    @forelse($groups as $group)
        @include('blocks.entity-line', [
            'header' => $group->name,
            'link' => route('admin.students.department.group', [
                'department' => $department->uri_alias,
                'group' => $group['uri_alias']
            ]),
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
            'link' => route('admin.students.department.new', ['department' => $department->uri_alias]),
            'text' => 'Створити групу'
        ])
    @endif
@endsection

@include('blocks.scripts.no-scripts')
