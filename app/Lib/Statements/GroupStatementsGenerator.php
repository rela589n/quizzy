<?php


namespace App\Lib\Statements;


use App\Exceptions\EmptyTestResultsException;
use App\Lib\GroupResultsManager;
use App\Lib\PHPWord\TemplateProcessor;
use App\Lib\Statements\FilePathGenerators\ResultFileNameGenerator;
use App\Lib\Words\WordsManager;
use App\Models\StudentGroup;
use App\Models\Test;
use Illuminate\Database\Eloquent\Collection;

class GroupStatementsGenerator extends StatementsGenerator
{
    /**
     * @var StudentGroup
     */
    protected $group;

    /**
     * @var Test
     */
    protected $test;

    /**
     * @var Collection
     */
    protected $testResults;

    /**
     * @var GroupResultsManager
     */
    protected $groupResultsManager;

    public function __construct(WordsManager $wordsManager, ResultFileNameGenerator $filePathGenerator, GroupResultsManager $groupResultsManager)
    {
        parent::__construct($wordsManager, $filePathGenerator);
        $this->groupResultsManager = $groupResultsManager;
    }

    /**
     * @param StudentGroup $group
     */
    public function setGroup(StudentGroup $group): void
    {
        $this->group = $group;
        $this->filePathGenerator->setGroup($group);
    }

    /**
     * @param Test $test
     */
    public function setTest(Test $test): void
    {
        $this->test = $test;
        $this->filePathGenerator->setTest($test);
    }

    /**
     * @param Collection $testResults
     */
    public function setTestResults(Collection $testResults): void
    {
        if (count($testResults) === 0) {
            throw new EmptyTestResultsException("Test results collection must have at least 1 element.");
        }

        $this->testResults = $testResults;
    }

    /**
     * @param TemplateProcessor $templateProcessor
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    protected function doGenerate(TemplateProcessor $templateProcessor): void
    {
        $templateProcessor->cloneRow('number', $this->testResults->count());

        $i = 1;
        foreach ($this->testResults as $result) {
            $templateProcessor->setValues([
                "number#$i"          => $i,
                "studentFullName#$i" => $result->user->full_name,
                "studentMark#$i"     => $result->mark
            ]);

            ++$i;
        }

        $this->groupResultsManager->setResults($this->testResults);
        $perfectCount = $this->groupResultsManager->getPerfectCount();
        $goodCount = $this->groupResultsManager->getGoodCount();
        $satisfactorilyCount = $this->groupResultsManager->getSatisfactorilyCount();
        $unsatisfactorilyCount = $this->groupResultsManager->getUnsatisfactorilyCount();

        $templateProcessor->setValues([
            'course'                   => $this->group->course,
            'groupName'                => $this->group->name,
            'averageMark'              => $this->groupResultsManager->getAverageMark(),
            'perfect'                  => $perfectCount,
            'perfectDeclined'          => $this->wordsManager->decline($perfectCount, 'студент'),
            'good'                     => $goodCount,
            'goodDeclined'             => $this->wordsManager->decline($goodCount, 'студент'),
            'satisfactorily'           => $satisfactorilyCount,
            'satisfactorilyDeclined'   => $this->wordsManager->decline($satisfactorilyCount, 'студент'),
            'unsatisfactorily'         => $unsatisfactorilyCount,
            'unsatisfactorilyDeclined' => $this->wordsManager->decline($unsatisfactorilyCount, 'студент')
        ]);

        $templateProcessor->setValues([
            'success' => $this->groupResultsManager->getSuccessPercentage(),
            'quality' => $this->groupResultsManager->getQualityPercentage()
        ]);
    }

    protected function templateResourcePath(): string
    {
        return 'templates/Group.docx';
    }
}
