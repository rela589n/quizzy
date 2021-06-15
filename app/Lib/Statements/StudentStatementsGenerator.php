<?php


namespace App\Lib\Statements;

use App\Exceptions\NullPointerException;
use App\Lib\PHPWord\TemplateProcessor;
use App\Lib\TestResultsEvaluator;
use App\Lib\Tests\Presenter\QuestionPresenter;
use App\Models\Question;
use App\Models\Questions\QuestionType;
use App\Models\TestResult;

class StudentStatementsGenerator extends StatementsGenerator
{
    public const EMPTY_WRONG_CHOICES_LABEL = 'відсутні';

    protected TestResult $result;
    protected TestResultsEvaluator $resultEvaluator;
    protected ?TemplateProcessor $templateProcessor = null;
    private bool $shouldStripHtml = false;

    public function setResult(TestResult $result): void
    {
        $this->result = $result;
        $this->filePathGenerator->setResult($this->result);
        $this->resultEvaluator = $this->result->getResultEvaluator();
    }

    public function shouldStripHtml(bool $shouldStripHtml = true): void
    {
        $this->shouldStripHtml = $shouldStripHtml;
    }

    /**
     * @param  TemplateProcessor  $templateProcessor
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
            $selectedAnswerPresenter = new SelectedAnswerPresenter(QuestionType::fromQuestion($question));
            $score = $questionsScore[$question->id] * 100; // score in percents

            $selectedNotRight = [];

            $j = 1;
            foreach ($askedQuestion->answers as $answer) {
                $this->setOptionInfo(
                    $i,
                    $j,
                    $answer->answerOption->text,
                    $selectedAnswerPresenter->labelForAnswer($answer),
                );

                if ($answer->is_chosen !== $answer->answerOption->is_right) {
                    $selectedNotRight[] = $j;
                }

                ++$j;
            }

            $this->setQuestionInfo(
                $i,
                $question,
                round($score, 2).' %',
                empty($selectedNotRight) ? self::EMPTY_WRONG_CHOICES_LABEL : implode(', ', $selectedNotRight)
            );

            ++$i;
        }

        $this->setSummary();
    }

    protected function setQuestionInfo(int $index, Question $question, string $score, string $selectedNotRight): void
    {
        $presenter = new QuestionPresenter($question, $this->shouldStripHtml);

        $this->templateProcessor->setValues(
            [
                "questionNumber#{$index}" => $index,
                "question#{$index}" => $presenter->plainText(),
                "questionScore#{$index}" => $score,
                "selectedNotRight#{$index}" => $selectedNotRight
            ]
        );
    }

    protected function setOptionInfo(int $questionIndex, int $optionIndex, string $optionText, string $selectedMark): void
    {
        $this->templateProcessor->setValues(
            [
                "optionNumber#${questionIndex}#${optionIndex}" => $optionIndex,
                "optionText#${questionIndex}#${optionIndex}" => $optionText,
                "optionSelected#${questionIndex}#${optionIndex}" => $selectedMark,
            ]
        );
    }

    protected function setSummary(): void
    {
        $this->templateProcessor->setValues(
            [
                'studentFullName' => $this->result->user->full_name,
                'subjectName' => $this->result->test->subject->name,
                'testName' => $this->result->test->name,
                'resultInPercents' => $this->result->result_percents_readable,
                'resultMark' => $this->result->mark_readable,
            ]
        );
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
