@extends('layouts.tests-single', ['baseLayout' => 'layouts.root.admin'])

@section('settings-link')
    <a class="btn btn-outline-dark finish-test-btn mt-1 float-right" href="{{ url()->current() }}/settings">Перейти до
        налаштувань теста</a>
@endsection

@section('subject-name') {{ $subject->name }} @endsection
@section('test-name') {{ $test->name }} @endsection

@section('test-questions')
    {{--  traverse given array and print all entities  --}}


    @foreach(old("q.deleted", []) as $deleted)
        @php
            dump($deleted);
        @endphp
    @endforeach


{{--  todo exclude deleted  --}}
    @forelse($test->nativeQuestions as $question)
        @include('blocks.admin.question-single', [
            'questionIndex' => $loop->iteration,
            'type' => 'modified',
            'modified' => boolval(old("q.modified.{$question->id}", false)),
            'new' => false
        ])

        {{--        <li class="list-group-item mb-4 question"--}}
        {{--            data-question="{{ $loop->iteration }}"--}}
        {{--            data-question-id="{{ $question->id }}"--}}
        {{--            data-new="false"--}}
        {{--            data-modified="false">--}}
        {{----}}
        {{--            <label for="q[modified][{{ $question->id }}][name]"--}}
        {{--                   class="text-center mb-3 h4 d-block question-header">--}}
        {{--                Питання № {{ $loop->iteration }}--}}
        {{--            </label>--}}
        {{----}}
        {{--            <button type="button" class="btn btn-danger position-absolute button-delete-question" tabindex="-1">--}}
        {{--                <i class="fas fa-trash"></i>--}}
        {{--            </button>--}}
        {{----}}
        {{--            <input type="text"--}}
        {{--                   id="q[modified][{{ $question->id }}][name]"--}}
        {{--                   name="q[modified][{{ $question->id }}][name]"--}}
        {{--                   class="form-control question-text" placeholder="Запитання"--}}
        {{--                   value="{{ $question->question }}" required="required">--}}
        {{----}}
        {{--            <div class="variants-wrapper">--}}
        {{--                @foreach($question->answerOptions as $option)--}}
        {{--                    @include('blocks.admin.answer-option-line')--}}
        {{--                @endforeach--}}
        {{--            </div>--}}
        {{----}}
        {{--            <button type="button" class="btn btn-outline-primary btn-sm button-add-variant mt-2"><i--}}
        {{--                    class="fas fa-plus"></i></button>--}}
        {{--        </li>--}}
    @empty
        <h3 class="list-group-item">В цього теста питань поки що немає. Ви можете створити їх натиснувши кнопку нижче:</h3>
    @endforelse

    @php
        dump($errors);
        dump(old());
    @endphp

    @foreach(old("q.new", []) as $id => $new)
        @php
            $question = new \stdClass();
            $question->id = $id;
            $question->answerOptions = [];

            foreach ($new['v'] as $vId => $variant) {
                $question->answerOptions[$vId] = new \stdClass();
                $question->answerOptions[$vId]->id = $vId;
                $question->answerOptions[$vId]->is_right = $variant['is_right'] ?? false;
            }
        @endphp

        @include('blocks.admin.question-single', [
            'questionIndex' => count($test->nativeQuestions) + $loop->iteration,
            'type' => 'new',
            'modified' => false,
            'new' => boolval(old("q.new.{$id}", false))
        ])
    @endforeach

    {{----}}
    {{--    <li class="list-group-item mb-4 question" data-question="1" data-question-id="28" data-new="false" data-modified="false">--}}
    {{--        <label for="modified[28][name]" class="text-center mb-3 h4 d-block question-header">Питання № 1</label>--}}
    {{----}}
    {{--        <button type="button" class="btn btn-danger position-absolute button-delete-question" tabindex="-1">--}}
    {{--            <i class="fas fa-trash"></i>--}}
    {{--        </button>--}}
    {{----}}
    {{--        <input type="text"--}}
    {{--               id="modified[28][name]"--}}
    {{--               class="form-control question-text" placeholder="Запитання"--}}
    {{--               value="Чи можна явно викликати приватний метод із похідних класів?" required="required">--}}
    {{----}}
    {{--        <div class="variants-wrapper">--}}
    {{--            <div class="form-row align-items-center" data-variant="1">--}}
    {{--                <div class="col-auto">--}}
    {{--                    <div class="form-check mb-2">--}}
    {{--                        <label class="form-check-label" for="[28][v][11][correct]"></label>--}}
    {{--                        <input class="form-check-input is-correct" type="checkbox" id="[28][v][11][correct]">--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="col-form-label col-xl-11 col-lg-10 col-sm-9 col-8">--}}
    {{--                    <label class="form-check-label d-block" for="[28][v][11][text]">--}}
    {{--                        <input type="text" class="form-control form-control-sm variant-text"--}}
    {{--                               id="[28][v][11][text]"--}}
    {{--                               placeholder="Варіант № 1" value="Так" required="required">--}}
    {{--                    </label>--}}
    {{--                </div>--}}
    {{----}}
    {{--                <div class="col-auto">--}}
    {{--                    <button type="button" class="btn btn-outline-danger btn-sm button-delete-variant"--}}
    {{--                            tabindex="-1"><i class="fas fa-trash"></i></button>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--            <div class="form-row align-items-center" data-variant="2">--}}
    {{--                <div class="col-auto">--}}
    {{--                    <div class="form-check mb-2">--}}
    {{--                        <label class="form-check-label" for="[28][v][12][correct]"></label>--}}
    {{--                        <input class="form-check-input is-correct" type="checkbox" id="[28][v][12][correct]"--}}
    {{--                               checked="checked">--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="col-form-label col-xl-11 col-lg-10 col-sm-9 col-8">--}}
    {{--                    <label class="form-check-label d-block" for="[28][v][12][text]">--}}
    {{--                        <input type="text" class="form-control form-control-sm variant-text"--}}
    {{--                               id="[28][v][12][text]"--}}
    {{--                               placeholder="Варіант № 2" value="Ні" required="required">--}}
    {{--                    </label>--}}
    {{--                </div>--}}
    {{--                <div class="col-auto">--}}
    {{--                    <button type="button" class="btn btn-outline-danger btn-sm button-delete-variant"--}}
    {{--                            tabindex="-1"><i class="fas fa-trash"></i></button>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--            <div class="form-row align-items-center" data-variant="3">--}}
    {{--                <div class="col-auto">--}}
    {{--                    <div class="form-check mb-2">--}}
    {{--                        <label class="form-check-label" for="[28][v][14][correct]"></label>--}}
    {{--                        <input class="form-check-input is-correct" type="checkbox" id="[28][v][14][correct]">--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="col-form-label col-xl-11 col-lg-10 col-sm-9 col-8">--}}
    {{--                    <label class="form-check-label d-block" for="[28][v][14][text]">--}}
    {{--                        <input type="text" class="form-control form-control-sm variant-text"--}}
    {{--                               id="[28][v][14][text]"--}}
    {{--                               placeholder="Варіант № 3" value="Не завжди" required="required">--}}
    {{--                    </label>--}}
    {{--                </div>--}}
    {{--                <div class="col-auto">--}}
    {{--                    <button type="button" class="btn btn-outline-danger btn-sm button-delete-variant"--}}
    {{--                            tabindex="-1"><i class="fas fa-trash"></i></button>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{----}}
    {{--    <button type="button" class="btn btn-outline-primary btn-sm button-add-variant mt-2"><i--}}
    {{--            class="fas fa-plus"></i></button>--}}
    {{--    </li>--}}
@endsection

@section('save-button')
    <button type="submit" class="btn btn-primary btn-block finish-test-btn mt-5 mb-5">Зберегти</button>
@endsection
