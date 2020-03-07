@extends('layouts.categories-single', ['baseLayout' => 'layouts.root.admin'])

@section('category-settings-link')
    <a class="btn btn-outline-dark finish-test-btn mt-1 float-right"
       href="{{ route('admin.students.group.settings', ['group' => $group->uri_alias]) }}">
        Перейти до налаштувань групи
    </a>
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
    <a class="btn btn-primary finish-test-btn mt-4 btn-block"
       href="{{ route('admin.students.group.new',  ['group' => $group->uri_alias]) }}">Створити студента</a>
@endsection
