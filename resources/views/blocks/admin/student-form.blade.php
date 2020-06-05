@extends('layouts.blocks.user-form')


@section('user-form-before')

    @if($authUser->can('make-student-class-monitor') && isset($user))
        @if(optional($user->studentGroup->classMonitor)->email === $user->email)

            <p class="text-right">Існує користувач-староста з заданим логіном.</p>

        @elseif(!isset($user->studentGroup->classMonitor))

            <a href="{{ route('admin.students.department.group.student.make-class-monitor', [
                    'department' => $user->studentGroup->department->uri_alias,
                    'group' => $user->studentGroup->uri_alias,
                    'studentId' => $user->id,
            ]) }}" class="mb-3 h6 btn-block text-right"
               title='Буде створено аккаунт в адмін-панелі з роллю "староста" та призначено старостою цієї групи'>Зробити
                старостою</a>

        @endif
    @endif

    @parent
@endsection

@section('user-form-additions')
    @if (!empty($studentGroups) && $authUser->can('edit-group-of-student'))
        <div class="form-group form-row align-items-start">
            <label for="student_group_id" class="form-info h3 m-0 col-3 col-sm-2">
                Група:
            </label>

            <div class="col-9 col-sm-10">
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
