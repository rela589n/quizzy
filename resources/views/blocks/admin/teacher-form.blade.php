@extends('layouts.blocks.user-form')

@section('user-form-additions')
    <div class="form-group form-row align-items-start">
        <label for="role" class="form-info h3 m-0 col-2">
            Роль:
        </label>
        <div class="col-10">
            <input id="role" name="role" type="text"
                   class="form-control @error('role') is-invalid @enderror" placeholder="Роль"
                   required="required" value="{{ old('role', $user->role ?? '') }}">

            @error('role')
            <span class="invalid-feedback" role="alert"><label for="role">{{ $message }}</label></span>
            @enderror
        </div>
    </div>
{{-- todo create administrator roles and permissions  --}}
@endsection
