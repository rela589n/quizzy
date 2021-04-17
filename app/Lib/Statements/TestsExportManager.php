<?php


namespace App\Lib\Statements;


use App\Lib\PHPWord\TemplateProcessor;
use App\Models\AnswerOption;
use App\Models\Question;
use App\Models\Questions\QuestionType;
use App\Models\Test;
use Illuminate\Database\Eloquent\Collection;

class TestsExportManager extends StatementsGenerator
{
    public const SELECTED_OPTION_LABEL = '*';
    public const SELECTED_RADIO_LABEL = '&';

    protected Test $test;

    public function setTest(Test $test): void
    {
        $this->test = $test;
        $this->filePathGenerator->setTest($test);
    }

    protected function doGenerate(TemplateProcessor $processor): void
    {
        /**
         * @var $questions Question[]|Collection
         */
        $questions = $this->test->nativeQuestions()
            ->with('answerOptions')
            ->get();

        $processor->cloneBlock(
            'questionBlock',
            $questions->count(),
            true,
            true
        );

        $i = 1;
        foreach ($questions as $question) {
            $processor->setValues(
                [
                    "questionNumber#$i" => $i,
                    "question#$i" => $question->question,
                ]
            );

            $processor->cloneBlock(
                "optionBlock#$i",
                $question->answerOptions->count(),
                true,
                true
            );

            $j = 1;
            foreach ($question->answerOptions as $answerOption) {
                $processor->setValues(
                    [
                        "optionNumber#$i#$j" => $j,
                        "optionText#$i#$j" => $answerOption->text,
                        "optionSelected#$i#$j" => $this->optionLabel($question, $answerOption),
                    ]
                );

                ++$j;
            }

            ++$i;
        }
    }

    private function optionLabel(Question $question, AnswerOption $option): string
    {
        if (!$option->is_right) {
            return '';
        }

        if (QuestionType::CHECKBOXES()
            ->equalsTo($question->type)) {
            return self::SELECTED_OPTION_LABEL;
        }

        if (QuestionType::RADIO()
            ->equalsTo($question->type)) {
            return self::SELECTED_RADIO_LABEL;
        }

        return '';
    }

    protected function templateResourcePath(): string
    {
        return 'templates/Test.docx';
    }
}
