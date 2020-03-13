<?php


namespace App\Lib\Statements;


use PhpOffice\PhpWord\TemplateProcessor;

class StudentStatementsGenerator extends StatementsGenerator
{
    public const SELECTED_OPTION_LABEL = '*';
    public const EMPTY_WRONG_CHOICES_LABEL = 'відсутні';

    /**
     * @param TemplateProcessor $templateProcessor
     * @throws \App\Exceptions\NullPointerException
     */
    protected function doGenerate(TemplateProcessor $templateProcessor)
    {
        $questionsScore = $this->resultEvaluator->getQuestionsScore();

        $templateProcessor->cloneBlock(
            'questionBlock',
            count($questionsScore),
            true,
            true
        );

        $i = 1;
        foreach ($this->result->askedQuestions as $askedQuestion) {
            $question = $askedQuestion->question;
            $score = $questionsScore[$question->id] * 5;
            $templateProcessor->setValues([
                "questionNumber#$i" => $i,
                "question#$i" => $question->question,
                "questionScore#$i" => round($score, 2) . $this->wordsManager->decline($score, ' бал')
            ]);

            $templateProcessor->cloneBlock(
                "optionBlock#$i",
                $askedQuestion->answers->count(),
                true,
                true
            );

            $selectedNotRight = [];

            $j = 1;
            foreach ($askedQuestion->answers as $answer) {
                $templateProcessor->setValues([
                    "optionNumber#$i#$j" => $j,
                    "optionText#$i#$j" => $answer->answerOption->text,
                    "optionSelected#$i#$j" => ($answer->is_chosen) ? self::SELECTED_OPTION_LABEL : ''
                ]);

                if ($answer->is_chosen != $answer->answerOption->is_right) {
                    $selectedNotRight[] = $j;
                }

                ++$j;
            }

            $templateProcessor->setValue(
                "selectedNotRight#$i",
                empty($selectedNotRight) ? self::EMPTY_WRONG_CHOICES_LABEL : implode(', ', $selectedNotRight)
            );

            ++$i;
        }

        $templateProcessor->setValues([
            'studentFullName' => $this->result->user->full_name,
            'subjectName' => $this->result->test->subject->name,
            'testName' => $this->result->test->name,
            'resultInPercents' => $this->result->score_readable,
            'resultMark' => $this->result->mark_readable
        ]);
    }

    protected function templateResourcePath(): string
    {
        return 'templates/Student.docx';
    }
}
