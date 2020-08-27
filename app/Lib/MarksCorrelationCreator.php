<?php


namespace App\Lib;


use App\Models\Test;
use App\Services\TestResults\MarksCollector;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;

class MarksCorrelationCreator
{
    protected MarksCollector $marksCollector;
    protected Test $test;

    protected array $markTypes = [
        'unsatisfactorily',
        'satisfactorily',
        'good',
        'perfect',
    ];

    /**
     * MarksCorrelationCreator constructor.
     * @param MarksCollector $marksCollector
     */
    public function __construct(MarksCollector $marksCollector)
    {
        $this->marksCollector = $marksCollector;
    }

    /**
     * @param int $mark
     * @return string corresponding type from $markTypes property
     */
    private function resolveMarkType(int $mark): string
    {
        $maxMark = $this->marks[count($this->marks) - 1];

        $blockSize = intdiv($maxMark, count($this->markTypes));

        if ($blockSize === 0) {
            return $this->markTypes[count($this->markTypes) - ($maxMark - $mark) - 1];
        }

        if ($maxMark % count($this->markTypes) === 0) {
            $firstBlockSize = $blockSize;
        } else {

            $firstBlockSize = $blockSize + $maxMark - ($blockSize * count($this->markTypes));
        }

        if ($mark <= $firstBlockSize) {
            return Arr::first($this->markTypes);
        }

        $block = ceil(($mark - $firstBlockSize) / $blockSize + 1);
        return $this->markTypes[$block - 1];
    }

    protected array $marks;

    /**
     * @return array
     * @throws BindingResolutionException
     */
    public function marksMap(): array
    {
        $marks = iterator_to_array($this->marksCollector->collect());
        $this->marks = $marks;

        $marksMap = [];
        foreach ($marks as $mark) {
            $marksMap[$mark] = $this->resolveMarkType($mark);
        }

        return $marksMap;
    }

    public function setTest(Test $test): self
    {
        $this->test = $test;
        $this->marksCollector->setTest($test);

        return $this;
    }
}
