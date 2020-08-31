<?php


namespace App\Lib\Statements;


use App\Exceptions\NullPointerException;
use App\Lib\PHPWord\TemplateProcessor;
use App\Lib\TestResultsEvaluator;
use App\Models\TestResult;

class StudentStatementsGenerator extends StatementsGenerator
{
    public const SELECTED_OPTION_LABEL = '*';
    public const EMPTY_WRONG_CHOICES_LABEL = 'відсутні';

    protected TestResult $result;
    protected TestResultsEvaluator $resultEvaluator;
    protected ?TemplateProcessor $templateProcessor = null;

    public function setResult(TestResult $result): void
    {
        $this->result = $result;
        $this->filePathGenerator->setResult($this->result);
        $this->resultEvaluator = $this->result->getResultEvaluator();
    }

    /**
     * @param TemplateProcessor $templateProcessor
     * @throws NullPointerException
     */
    protected function doGenerate(TemplateProcessor $templateProcessor): void
    {
        $this->templateProcessor = $templateProcessor;

        $questionsScore = $this->resultEvaluator->getQuestionsScore();

        $this->buildSkeleton();

        $i = 1;
        foreach ($this->result->askedQuestions as $askedQuestion) {

            $question = $askedQuestion->question;
            $score = $questionsScore[$question->id] * 100; // score in percents

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
                round($score, 2) . ' %',
                empty($selectedNotRight) ? self::EMPTY_WRONG_CHOICES_LABEL : implode(', ', $selectedNotRight)
            );

            ++$i;
        }

        $this->setSummary();
    }

    protected function setQuestionInfo(int $index, string $question, string $score, string $selectedNotRight): void
    {
        $this->templateProcessor->setValues([
            "questionNumber#{$index}"   => $index,
            "question#{$index}"         => $question,
            "questionScore#{$index}"    => $score,
            "selectedNotRight#{$index}" => $selectedNotRight
        ]);
    }

    protected function setOptionInfo(int $questionIndex, int $optionIndex, string $optionText, string $selectedMark): void
    {
        $this->templateProcessor->setValues([
            "optionNumber#${questionIndex}#${optionIndex}"   => $optionIndex,
            "optionText#${questionIndex}#${optionIndex}"     => $optionText,
            "optionSelected#${questionIndex}#${optionIndex}" => $selectedMark,
        ]);
    }

    protected function setSummary(): void
    {
        $this->templateProcessor->setValues([
            'studentFullName'  => $this->result->user->full_name,
            'subjectName'      => $this->result->test->subject->name,
            'testName'         => $this->result->test->name,
            'resultInPercents' => $this->result->score_readable,
            'resultMark'       => $this->result->mark_readable
        ]);
    }

    protected function buildSkeleton(): void
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

    protected function cloneBlock(string $blockName, int $clones): void
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
