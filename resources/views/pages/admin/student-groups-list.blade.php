@extends('layouts.categories-list', ['baseLayout' => 'layouts.root.admin' ])

@section('category-header')
    <h2 class="mb-4">Список груп студентів:</h2>
@endsection

@section('category-links')
    @forelse($groups as $group)
        @include('blocks.admin.student-group-line', ['group' => $group])
    @empty
        @component('layouts.blocks.empty-list-message')
            Немає жодної групи
        @endcomponent
    @endforelse
@endsection

@section('create-new-btn')
    @include('blocks.admin.create-new-link', [
        'link' => route('admin.students.new'),
        'text' => 'Створити групу'
    ])
@endsection
