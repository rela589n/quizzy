<li class="list-group-item mb-4 question">
    <h4 class="text-center">Питання № {{ $questionIndex }}</h4>

    <h5>{{ $question->question }}</h5>

    @yield('answer-options')
</li>
