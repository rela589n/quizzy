<?php


namespace App\Repositories;


use App\Http\Requests\RequestUrlManager;
use App\Models\TestSubject;

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

}
