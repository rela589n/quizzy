<?php


namespace App\Lib\Statements;


use App\Lib\PHPWord\TemplateProcessor;
use App\Lib\TestResultsEvaluator;
use App\Models\TestResult;

class StudentStatementsGenerator extends StatementsGenerator
{
    public const SELECTED_OPTION_LABEL = '*';
    public const EMPTY_WRONG_CHOICES_LABEL = 'відсутні';

    /**
     * @var TestResult
     */
    protected $result;

    /**
     * @var TestResultsEvaluator
     */
    protected $resultEvaluator;

    /**
     * @var TemplateProcessor|null
     */
    protected $templateProcessor = null;

    /**
     * @param TestResult $result
     */
    public function setResult(TestResult $result): void
    {
        $this->result = $result;
        $this->filePathGenerator->setResult($this->result);
        $this->resultEvaluator = $this->result->getResultEvaluator();
    }

    /**
     * @param TemplateProcessor $templateProcessor
     * @throws \App\Exceptions\NullPointerException
     */
    protected function doGenerate(TemplateProcessor $templateProcessor): void
    {
        $this->templateProcessor = $templateProcessor;

        $questionsScore = $this->resultEvaluator->getQuestionsScore();

        $this->buildSkeleton();

        $i = 1;
        foreach ($this->result->askedQuestions as $askedQuestion) {

            $question = $askedQuestion->question;
            $score = $questionsScore[$question->id] * 5;

            $selectedNotRight = [];

            $j = 1;
            foreach ($askedQuestion->answers as $answer) {
                $this->setOptionInfo(
                    $i,
                    $j,
                    $answer->answerOption->text,
                    ($answer->is_chosen) ? self::SELECTED_OPTION_LABEL : ''
                );

                if ($answer->is_chosen !== $answer->answerOption->is_right) {
                    $selectedNotRight[] = $j;
                }

                ++$j;
            }

            $this->setQuestionInfo(
                $i,
                $question->question,
                round($score, 2) . $this->wordsManager->decline($score, ' бал'),
                empty($selectedNotRight) ? self::EMPTY_WRONG_CHOICES_LABEL : implode(', ', $selectedNotRight)
            );

            ++$i;
        }

        $this->setSummary();
    }

    protected function setQuestionInfo(int $index, string $question, string $score, string $selectedNotRight)
    {
        $this->templateProcessor->setValues([
            "questionNumber#{$index}"   => $index,
            "question#{$index}"         => $question,
            "questionScore#{$index}"    => $score,
            "selectedNotRight#{$index}" => $selectedNotRight
        ]);
    }

    protected function setOptionInfo(int $questionIndex, int $optionIndex, string $optionText, string $selectedMark)
    {
        $this->templateProcessor->setValues([
            "optionNumber#${questionIndex}#${optionIndex}"   => $optionIndex,
            "optionText#${questionIndex}#${optionIndex}"     => $optionText,
            "optionSelected#${questionIndex}#${optionIndex}" => $selectedMark,
        ]);
    }

    protected function setSummary()
    {
        $this->templateProcessor->setValues([
            'studentFullName'  => $this->result->user->full_name,
            'subjectName'      => $this->result->test->subject->name,
            'testName'         => $this->result->test->name,
            'resultInPercents' => $this->result->score_readable,
            'resultMark'       => $this->result->mark_readable
        ]);
    }

    protected function buildSkeleton()
    {
        $this->cloneBlock(
            'questionBlock',
            count($this->result->askedQuestions)
        );

        $i = 1;
        foreach ($this->result->askedQuestions as $askedQuestion) {

            $this->cloneBlock(
                "optionBlock#$i",
                $askedQuestion->answers->count()
            );

            ++$i;
        }
    }

    protected function cloneBlock(string $blockName, int $clones)
    {
        $this->templateProcessor->cloneBlock(
            $blockName,
            $clones,
            true,
            true
        );
    }

    protected function templateResourcePath(): string
    {
        return 'templates/Student.docx';
    }

}
