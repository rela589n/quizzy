<?php


namespace App\Repositories;


use App\Http\Requests\RequestUrlManager;
use App\Models\Test;
use Illuminate\Database\Eloquent\Relations\Relation;

class TestsRepository
{
    protected RequestUrlManager $urlManager;

    public function __construct(RequestUrlManager $urlManager)
    {
        $this->urlManager = $urlManager;
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

    public function testsForSelectingByUser()
    {
        return tap(
            $this->urlManager->getCurrentSubject()
                ->tests()
                ->with('testComposites'),
            function (Relation $builder) {
                $this->applyOrder($builder);
            }
        )->get()
            ->each(
                static function (Test $test) {
                    $test->questions_count = $test->allQuestions()->count();
                }
            );
    }

    protected function applyOrder(Relation $builder): void
    {
        $builder->orderBy('name');
    }
}
