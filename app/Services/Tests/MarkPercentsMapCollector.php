<?php


namespace App\Services\Tests;


use App\Models\Test;
use App\Repositories\MarkPercentsRepository;

class MarkPercentsMapCollector
{
    /**
     * @var MarkPercentsRepository
     */
    private $markPercentsRepository;
    /**
     * @var MarkPercentsManager
     */
    private $markPercentsManager;

    public function __construct(MarkPercentsRepository $markPercentsRepository, MarkPercentsManager $markPercentsManager)
    {
        $this->markPercentsRepository = $markPercentsRepository;
        $this->markPercentsManager = $markPercentsManager;
    }

    /**
     * @var Test
     */
    private $test;

    /**
     * @param Test $test
     * @return MarkPercentsMapCollector
     */
    public function setTest(Test $test): self
    {
        $this->test = $test;

        return $this;
    }

    public function markPercents()
    {
        return $this->markPercentsManager
            ->setModels(function () {
                if ($this->test === null) {
                    return [];
                }

                return $this->markPercentsRepository->mapForTest($this->test);
            })
            ->handle(old('correlation_table'));
    }
}
