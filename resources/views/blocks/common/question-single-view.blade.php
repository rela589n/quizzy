<li class="list-group-item mb-4 question">
    <h4 class="text-center">Питання № {{ $questionIndex + 1 }}</h4>

    <div class="h5 @if($restrictTextSelect) no-select @endif no-drag">{!! $question->question !!}</div>

    @yield('answer-options')
</li>
