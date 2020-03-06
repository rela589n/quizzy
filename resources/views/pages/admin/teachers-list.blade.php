@extends('layouts.categories-list', ['baseLayout' => 'layouts.root.admin' ])

@section('category-header')
    <h2 class="mb-4">Список викладачів:</h2>
@endsection

@section('category-links')
    @forelse($teachers as $teacher)
        @include('blocks.admin.teacher-line', ['teacherRouteName' => 'admin.teachers.teacher', 'teacher' => $teacher])
    @empty
        @component('layouts.blocks.empty-list-message')
            Додайте викладача натиснувши кнопку нижче:
        @endcomponent
    @endforelse
@endsection

@section('create-new-btn')
    @include('blocks.admin.create-new-link', [
        'link' => route('admin.teachers.new'),
        'text' => 'Створити нового'
    ])
@endsection

