@extends('layouts.blocks.user-info')

@section('user-info-additions')
    @include('blocks.info-row', [
        'key' => 'Роль:',
        'val' => $user->roles_readable ?: 'відсутня'
    ])
@endsection
