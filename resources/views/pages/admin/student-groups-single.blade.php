@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.admin'])

@section('title')
    {{ $group->name }} - список студентів
@endsection

@section('content')
    {{ Breadcrumbs::render('admin.students.group', $group) }}
    @parent
@endsection

@section('category-settings-link')
    @if($authUser->can('update-groups'))
        @include('blocks.admin.settings-link', [
            'link' => route('admin.students.group.settings', ['group' => $group->uri_alias]),
            'text' => 'Перейти до налаштувань групи'
        ])
    @endif
@endsection

@section('category-header-text') Студенти групи {{ $group->name }} @endsection

@section('category-links')
    @forelse($group->students as $student)
        @include('blocks.entity-line', [
            'header' => $student->full_name,
            'link' => route('admin.students.group.student', ['group' => $group->uri_alias, 'studentId' => $student->id]),
        ])
    @empty
        @component('layouts.blocks.empty-list-message')
            Група поки що пуста. Можете додати в неї студентів натиснувши кнопку нижче:
        @endcomponent
    @endforelse
@endsection

@section('category-new-btn')
    @if($authUser->can('create-students'))
        @include('blocks.admin.create-new-link', [
            'link' => route('admin.students.group.new',  ['group' => $group->uri_alias]),
            'text' => 'Створити студента'
        ])
    @endif
@endsection
