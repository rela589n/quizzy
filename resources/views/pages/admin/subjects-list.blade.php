@extends('layouts.categories-list', ['baseLayout' => 'layouts.root.admin' ])

@section('header')
    <h2 class="mb-4">Усі доступні предмети тестування:</h2>
@endsection

@section('subject-links')
    @foreach($subjects as $subject)
        @include('blocks.admin.subject-line', ['subject' => $subject])
    @endforeach
@endsection

@section('create-new-btn')
    @include('blocks.admin.create-new-link', [
        'link' => route('admin.tests.new')
    ])
@endsection
