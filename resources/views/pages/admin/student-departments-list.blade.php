@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.admin' ])

@section('title')
    Відділення студентів
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.students') }}
    @parent
@endsection

@section('category-header-text')
    Список відділень студентів:
@endsection

@section('category-links')
    @forelse($departments as $department)
        @include('blocks.entity-line', [
            'header' => $department->name,
            'link' => route('admin.students.department', ['department' => $department['uri_alias'] ]),
            'badge' => $department->student_groups_count,
        ])
    @empty
        @component('layouts.blocks.empty-list-message')
            Немає жодного відділення
        @endcomponent
    @endforelse
@endsection


@section('category-new-btn')
    @if ($authUser->can('create-departments'))
        @include('blocks.admin.create-new-link', [
            'link' => route('admin.students.new'),
            'text' => 'Створити відділення'
        ])
    @endif
@endsection

@include('blocks.scripts.no-scripts')
