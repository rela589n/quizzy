<?php


namespace App\Lib\Statements;


use App\Exceptions\EmptyTestResultsException;
use App\Lib\GroupResultsManager;
use App\Lib\MarksCorrelationCreator;
use App\Lib\PHPWord\TemplateProcessor;
use App\Lib\Statements\FilePathGenerators\ResultFileNameGenerator;
use App\Lib\Words\WordsManager;
use App\Models\StudentGroup;
use App\Models\Test;
use App\Models\TestResult;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use PhpOffice\PhpWord\Exception\Exception as PhpWordException;

class GroupStatementsGenerator extends StatementsGenerator
{
    protected StudentGroup $group;
    protected Test $test;
    /** @var Collection|TestResult[] */
    protected Collection $testResults;
    protected GroupResultsManager $groupResultsManager;
    protected MarksCorrelationCreator $marksCorrelationCreator;

    public function __construct(
        WordsManager $wordsManager,
        ResultFileNameGenerator $filePathGenerator,
        GroupResultsManager $groupResultsManager,
        MarksCorrelationCreator $marksCorrelationCreator
    ) {
        parent::__construct($wordsManager, $filePathGenerator);

        $this->groupResultsManager = $groupResultsManager;
        $this->marksCorrelationCreator = $marksCorrelationCreator;
    }

    /**
     * @param  StudentGroup  $group
     */
    public function setGroup(StudentGroup $group): void
    {
        $this->group = $group;
        $this->filePathGenerator->setGroup($group);
    }

    public function setTest(Test $test): void
    {
        $this->test = $test;
        $this->filePathGenerator->setTest($test);

        $this->groupResultsManager->setMarksCorrelation(
            $this->marksCorrelationCreator
                ->setTest($test)
                ->marksMap()
        );
    }

    /**
     * @param  Collection  $testResults
     */
    public function setTestResults(Collection $testResults): void
    {
        if (count($testResults) === 0) {
            throw new EmptyTestResultsException("Test results collection must have at least 1 element.");
        }

        $this->testResults = $testResults;
    }

    /**
     * @param  TemplateProcessor  $templateProcessor
     * @throws PhpWordException
     */
    protected function doGenerate(TemplateProcessor $templateProcessor): void
    {
        $templateProcessor->cloneRow('number', $this->testResults->count());

        $i = 1;
        foreach ($this->testResults as $result) {
            $templateProcessor->setValues(
                [
                    "number#$i"          => $i,
                    "studentFullName#$i" => $result->user->full_name,
                    "studentMark#$i"     => $result->result_mark,
                ]
            );

            ++$i;
        }

        $this->groupResultsManager->setResults($this->testResults);
        $perfectCount = $this->groupResultsManager->getPerfectCount();
        $goodCount = $this->groupResultsManager->getGoodCount();
        $satisfactorilyCount = $this->groupResultsManager->getSatisfactorilyCount();
        $unsatisfactorilyCount = $this->groupResultsManager->getUnsatisfactorilyCount();

        $templateProcessor->setValues(
            [
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
            ]
        );

        $templateProcessor->setValues(
            [
                'success' => $this->groupResultsManager->getSuccessPercentage(),
                'quality' => $this->groupResultsManager->getQualityPercentage()
            ]
        );
    }

    protected function templateResourcePath(): string
    {
        return 'templates/Group.docx';
    }
}
