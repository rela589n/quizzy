<?php


namespace App\Repositories;


use App\Http\Requests\RequestUrlManager;
use App\Lib\Tests\Pass\Query\QuestionsRepository;
use App\Lib\Words\WordsManager;
use App\Models\Test;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;

class TestsRepository
{
    protected RequestUrlManager $urlManager;

    private WordsManager $wordsManager;

    public function __construct(RequestUrlManager $urlManager, WordsManager $wordsManager)
    {
        $this->urlManager = $urlManager;
        $this->wordsManager = $wordsManager;
    }

    public function testsForResultPage()
    {
        return tap(
            $this->urlManager->getCurrentSubject(true)
                ->tests()
                ->withTrashed()
                ->whereHas('testResults'),
            function (Relation $query) {
                $this->applyOrder($query);
            }
        )->get();
    }

    public function testsForSubjectPage()
    {
        return tap(
            $this->urlManager->getCurrentSubject()
                ->tests()
                ->withCount('nativeQuestions as questions_count')
            ,
            function (Relation $query) {
                $this->applyOrder($query);
            }
        )->get();
    }

    public function testsForSelectingByUser(User $user)
    {
        return tap(
            $this->urlManager->getCurrentSubject()
                ->tests()
                ->whereIsPublished(true)
                ->with('testComposites')
                ->withCount('testResults')
                ->withUserResultsCount($user),
            function (Relation $builder) {
                $this->applyOrder($builder);
            }
        )->get()
            ->each(
                static function (Test $test) {
                    $gate = new QuestionsRepository();

                    $test->questions_count = $gate->readTestQuestionsCount($test);
                }
            )
            ->filter(
                static fn(Test $test) => optional(
                        $test->attempts_per_user,
                        static fn() => $test->attempts_per_user - $test->user_results_count > 0
                    ) ?? true
            )
            ->each(
                function (Test $test) {
                    if (null === $test->attempts_per_user) {
                        return;
                    }

                    $attempts = $test->attempts_per_user - $test->user_results_count;
                    $test->remainingAttemptsMessage = "{$attempts} {$this->wordsManager->decline($attempts, 'спроб')}";
                }
            );
    }

    protected function applyOrder(Relation $builder): void
    {
        $builder->orderBy('name');
    }
}
