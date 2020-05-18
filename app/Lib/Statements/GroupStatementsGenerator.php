<?php


namespace App\Lib\Statements;


use App\Lib\GroupResultsManager;
use App\Lib\PHPWord\TemplateProcessor;
use App\Lib\Statements\FilePathGenerators\ResultFileNameGenerator;
use App\Lib\Words\WordsManager;
use App\Models\StudentGroup;
use App\Models\Test;

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
     * @param TemplateProcessor $templateProcessor
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    protected function doGenerate(TemplateProcessor $templateProcessor): void
    {
        $results = $this->group->lastResults($this->test)->get();

        // todo create wrapper under loading missing relations
        $results->loadMissing([
            'askedQuestions.question' => function ($query) {
                $query->withTrashed();
            },
            'askedQuestions.answers.answerOption' => function ($query) {
                $query->withTrashed();
            },
            'user.studentGroup' => function ($query) {
                $query->withTrashed();
            }
        ]);


        $templateProcessor->cloneRow('number', $results->count());

        $i = 1;
        foreach ($results as $result) {
            $templateProcessor->setValues([
                "number#$i" => $i,
                "studentFullName#$i" => $result->user->full_name,
                "studentMark#$i" => $result->mark
            ]);

            ++$i;
        }

        $this->groupResultsManager->setResults($results);
        $perfectCount = $this->groupResultsManager->getPerfectCount();
        $goodCount = $this->groupResultsManager->getGoodCount();
        $satisfactorilyCount = $this->groupResultsManager->getSatisfactorilyCount();
        $unsatisfactorilyCount = $this->groupResultsManager->getUnsatisfactorilyCount();

        $templateProcessor->setValues([
            'course' => $this->group->course,
            'groupName' => $this->group->name,
            'averageMark' => $this->groupResultsManager->getAverageMark(),
            'perfect' => $perfectCount,
            'perfectDeclined' => $this->wordsManager->decline($perfectCount, 'студент'),
            'good' => $goodCount,
            'goodDeclined' => $this->wordsManager->decline($goodCount, 'студент'),
            'satisfactorily' => $satisfactorilyCount,
            'satisfactorilyDeclined' => $this->wordsManager->decline($satisfactorilyCount, 'студент'),
            'unsatisfactorily' => $unsatisfactorilyCount,
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
