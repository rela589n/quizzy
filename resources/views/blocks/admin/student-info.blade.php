@extends('layouts.blocks.user-info')

@section('user-info-additions')
    @include('blocks.info-row', [
        'key' => 'Група:',
        'val' => $user->studentGroup->name ?: 'відсутня'
    ])
@endsection
