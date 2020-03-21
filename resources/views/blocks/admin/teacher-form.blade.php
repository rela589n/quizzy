@extends('layouts.blocks.user-form')

@section('user-form-additions')
    @if(!empty($roles))
        <div class="form-group form-row align-items-start">
            <label for="role_ids" class="form-info h3 m-0 col-2">
                Роль:
            </label>
            <div class="col-10">

                <div class="form-group">
                    <select class="selectpicker form-control dropup @error('role_ids') is-invalid @enderror"
                            data-dropup-auto="false" data-style="btn-outline-secondary selectpicker-button"
                            multiple="multiple"
                            title="Оберіть роль користувача" required="required"
                            id="role_ids" name="role_ids[]">

                        @php
                            $oldRoleValues = array_flip(old('role_ids', []));
                        @endphp

                        @foreach($roles as $role)
                            <option value="{{ $role->id }}"
                                    @if(array_key_exists("$role->id", $oldRoleValues) ?: optional($user ?? null)->hasRole($role))
                                            selected="selected"
                                    @endif>
                                {{ $role->public_name }}
                            </option>
                        @endforeach
                    </select>

                    @error('role_ids')
                    <span class="invalid-feedback" role="alert"><label for="role_ids">{{ $message }}</label></span>
                    @enderror
                </div>
            </div>
        </div>
    @endif

    {{-- todo handle admin permissions  --}}
@endsection

@section('head_styles')
    @parent
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@endsection

@push('bottom_scripts')
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
@endpush
