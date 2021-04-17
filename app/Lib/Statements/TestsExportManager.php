<?php


namespace App\Lib\Statements;

use App\Lib\PHPWord\TemplateProcessor;
use App\Models\Question;
use App\Models\Questions\QuestionType;
use App\Models\Test;
use Illuminate\Database\Eloquent\Collection;

class TestsExportManager extends StatementsGenerator
{
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
            $answerOptionPresenter =  new SelectedAnswerPresenter(QuestionType::fromQuestion($question));

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
                        "optionSelected#$i#$j" => $answerOptionPresenter->labelFor($answerOption),
                    ]
                );

                ++$j;
            }

            ++$i;
        }
    }

    protected function templateResourcePath(): string
    {
        return 'templates/Test.docx';
    }
}
