<?php


namespace App\Services\Tests;


use App\Models\Test;
use App\Repositories\MarkPercentsRepository;

class MarkPercentsMapCollector
{
    private MarkPercentsRepository $markPercentsRepository;
    private MarkPercentsManager $markPercentsManager;

    public function __construct(
        MarkPercentsRepository $markPercentsRepository,
        MarkPercentsManager $markPercentsManager
    ) {
        $this->markPercentsRepository = $markPercentsRepository;
        $this->markPercentsManager = $markPercentsManager;
    }

    private ?Test $test = null;

    /**
     * @param  Test  $test
     * @return $this
     */
    public function setTest(Test $test): self
    {
        $this->test = $test;

        return $this;
    }

    public function markPercents()
    {
        return $this->markPercentsManager
            ->setModels(
                function () {
                    if ($this->test === null) {
                        return [];
                    }

                    return $this->markPercentsRepository->mapForTest($this->test);
                }
            )
            ->handle(old('correlation_table'));
    }
}
