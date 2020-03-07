@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.admin'])

@section('category-settings-link')
    @include('blocks.admin.settings-link', [
        'link' => route('admin.students.group.settings', ['group' => $group->uri_alias]),
        'text' => 'Перейти до налаштувань групи'
    ])
@endsection

@section('category-header-text') Студенти групи {{ $group->name }} @endsection

@section('category-links')
    @forelse($group->students as $student)
        @include('blocks.admin.student-line', [
            'studentRouteName' => 'admin.students.group.student'
        ])
    @empty
        @component('layouts.blocks.empty-list-message')
            Група поки що пуста. Можете додати в неї студентів натиснувши кнопку нижче:
        @endcomponent
    @endforelse
@endsection

@section('category-new-btn')
    @include('blocks.admin.create-new-link', [
        'link' => route('admin.students.group.new',  ['group' => $group->uri_alias]),
        'text' => 'Створити студента'
    ])
@endsection
