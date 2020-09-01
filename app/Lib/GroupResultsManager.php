<?php


namespace App\Lib;


use App\Models\TestResult;
use Illuminate\Database\Eloquent\Collection;

class GroupResultsManager
{
    /**
     * @var TestResult[] | Collection
     */
    protected ?Collection $testResults = null;

    protected array $marksCorrelation = [
        5 => 'perfect',
        4 => 'good',
        3 => 'satisfactorily',
        2 => 'unsatisfactorily',
        1 => 'unsatisfactorily',
    ];

    private $perfect = null;
    private $good = null;
    private $satisfactorily = null;
    private $unsatisfactorily = null;

    private $success = null;
    private $quality = null;
    private $averageMark = null;

    public function setResults(Collection $testResults): void
    {
        $this->testResults = $testResults;
    }

    /**
     * @param  array  $marksCorrelation
     * @return GroupResultsManager
     */
    public function setMarksCorrelation(array $marksCorrelation): self
    {
        $this->marksCorrelation = $marksCorrelation;

        return $this;
    }

    private function nullifyProperties(): void
    {
        foreach ($this->marksCorrelation as $propName) {
            $this->$propName = 0;
        }
    }

    public function __evaluate()
    {
        $this->nullifyProperties();

        $marksSum = 0;
        foreach ($this->testResults as $result) {
            $marksSum += $result->mark;
            $fieldName = $this->marksCorrelation[$result->mark];
            ++$this->$fieldName;
        }

        $resultsCount = $this->testResults->count();

        $this->quality = ($this->perfect + $this->good) * 100 / $resultsCount;
        $this->success = ($resultsCount - $this->unsatisfactorily) * 100 / $resultsCount;
        $this->averageMark = $marksSum / $resultsCount;
    }

    public function getPerfectCount(): int
    {
        return singleVar($this->perfect, [$this, '__evaluate']);
    }

    public function getGoodCount(): int
    {
        return singleVar($this->good, [$this, '__evaluate']);
    }

    public function getSatisfactorilyCount(): int
    {
        return (int)singleVar($this->satisfactorily, [$this, '__evaluate']);
    }

    public function getUnsatisfactorilyCount(): int
    {
        return (int)singleVar($this->unsatisfactorily, [$this, '__evaluate']);
    }

    public function getSuccessPercentage(): float
    {
        return floatReadable(singleVar($this->success, [$this, '__evaluate']));
    }

    public function getQualityPercentage(): float
    {
        return floatReadable(singleVar($this->quality, [$this, '__evaluate']));
    }

    public function getAverageMark(): float
    {
        return floatReadable(singleVar($this->averageMark, [$this, '__evaluate']));
    }
}
