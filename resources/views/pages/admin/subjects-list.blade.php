@extends('layouts.categories-list', ['baseLayout' => 'layouts.root.admin' ])

@section('category-header')
    <h2 class="mb-4">Усі доступні предмети тестування:</h2>
@endsection

@section('category-links')
    @forelse($subjects as $subject)
        @include('blocks.admin.subject-line', ['subject' => $subject])
    @empty
        @component('layouts.blocks.empty-list-message')
            Немає жодного доступного предмета
        @endcomponent
    @endforelse
@endsection

@section('create-new-btn')
    @include('blocks.admin.create-new-link', [
        'link' => route('admin.tests.new')
    ])
@endsection
