<?php


namespace App\Repositories;


use App\Http\Requests\RequestUrlManager;
use App\Models\Test;

class TestsRepository
{
    /** @var RequestUrlManager */
    protected $urlManager;

    /**
     * TestsRepository constructor.
     * @param RequestUrlManager $urlManager
     */
    public function __construct(RequestUrlManager $urlManager)
    {
        $this->urlManager = $urlManager;
    }

    public function testsForResultPage()
    {
        return $this->urlManager->getCurrentSubject(true)
            ->tests()
            ->withTrashed()
            ->orderBy('name')
            ->whereHas('testResults')
            ->get();
    }

    public function testsForSubjectPage()
    {
        return $this->urlManager->getCurrentSubject()
            ->tests()
            ->orderBy('name')
            ->withCount('nativeQuestions as questions_count')
            ->get();
    }

    public function testsForSelectingByUser()
    {
        return $this->urlManager->getCurrentSubject()
            ->tests()
            ->with('testComposites')
            ->orderBy('name')
            ->get()
            ->each(function (Test $test) {
                $test->questions_count = $test->allQuestions()->count();
            });
    }
}
