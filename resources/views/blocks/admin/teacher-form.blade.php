@extends('layouts.blocks.user-form')

@section('user-form-additions')
    @if(!empty($roles))
        <div class="form-group form-row align-items-start">
            <label for="role_ids" class="form-info h3 m-0 col-3 col-sm-2">
                Роль:
            </label>
            <div class="col-9 col-sm-10">
                <div class="form-group">
                    <select class="selectpicker form-control dropup @error('role_ids.*') is-invalid @enderror"
                            data-dropup-auto="false" data-style="btn-outline-secondary selectpicker-button"
                            multiple="multiple"
                            title="Оберіть роль користувача" required="required"
                            id="role_ids" name="role_ids[]">

                        @php( $oldRoleValues = array_flip(old('role_ids', [])) )

                        @foreach($roles as $role)
                            <option value="{{ $role->id }}"
                                    @if(array_key_exists("$role->id", $oldRoleValues) ?: optional($user ?? null)->hasRole($role))
                                    selected="selected"
                                @endif>
                                {{ $role->public_name }}
                            </option>
                        @endforeach
                    </select>

                    @error('role_ids.*')
                    <span class="invalid-feedback" role="alert"><label for="role_ids">{{ $message }}</label></span>
                    @enderror
                </div>
            </div>
        </div>
    @endif
@endsection

@section('head_styles')
    @parent
    @include('blocks.styles.bootstrap-select')
@endsection

@section('bottom-scripts')
    @parent
    @include('blocks.scripts.bootstrap-select')
@endsection
