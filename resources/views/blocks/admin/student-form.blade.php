@extends('layouts.blocks.user-form')

@section('user-form-additions')
    @if (!empty($studentGroups))
        <div class="form-group form-row align-items-start">
            <label for="student_group_id" class="form-info h3 m-0 col-2">
                Група:
            </label>

            <div class="col-10">
                <select class="browser-default custom-select @error('student_group_id') is-invalid @enderror"
                        required="required"
                        id="student_group_id"
                        name="student_group_id">

                    @foreach($studentGroups as $group)
                        <option value="{{ $group->id }}"
                                @if($group->id === $user->studentGroup->id) selected="selected" @endif>{{ $group->name }}</option>
                    @endforeach
                </select>

                @error('student_group_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror</div>
        </div>
    @endif
@endsection
