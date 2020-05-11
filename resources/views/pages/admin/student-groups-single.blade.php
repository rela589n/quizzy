@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.admin'])

@section('title')
    {{ $group->name }} - список студентів
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.students.department.group', $department, $group) }}
    @parent
@endsection

@section('category-settings-link')
    @if($authUser->can('update', $group))
        @include('blocks.admin.settings-link', [
            'link' => route('admin.students.department.group.settings', [
                'department' => $department->uri_alias,
                'group' => $group->uri_alias
            ]),
            'text' => 'Перейти до налаштувань групи'
        ])
    @endif
@endsection

@section('category-header-text') Студенти групи {{ $group->name }}: @endsection

@section('category-links')
    @forelse($group->students as $student)
        @include('blocks.entity-line', [
            'header' => $student->full_name,
            'link' => route('admin.students.department.group.student', [
                'department' => $department->uri_alias,
                'group' => $group->uri_alias,
                'studentId' => $student->id
            ]),
        ])
    @empty
        @component('layouts.blocks.empty-list-message')
            Немає студентів
        @endcomponent
    @endforelse
@endsection

@section('category-new-btn')
    @if($authUser->can('create-students'))
        @include('blocks.admin.create-new-link', [
            'link' => route('admin.students.department.group.new',  [
                'department' => $department->uri_alias,
                'group' => $group->uri_alias
            ]),
            'text' => 'Зареєструвати'
        ])
    @endif
@endsection

@include('blocks.scripts.no-scripts')
