<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Tests\ImportTestRequest;
use App\Lib\Parsers\TestDocxParser;
use App\Models\Question;
use PhpOffice\PhpWord\IOFactory;

class TestsTransferController extends AdminController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showImportForm()
    {
        $test = $this->urlManager->getCurrentTest();
        $this->authorize('update', $test);

        $subject = $this->urlManager->getCurrentSubject();

        return view('pages.admin.tests-import', compact('subject', 'test'));
    }

    /**
     * @param ImportTestRequest $request
     * @param TestDocxParser $parser
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\NullPointerException
     */
    public function import(ImportTestRequest $request, TestDocxParser $parser)
    {
        $test = $this->urlManager->getCurrentTest();
        $file = $request->file('selected-file');

        $phpWord = IOFactory::load($file->path());

        $parser->setPhpWord($phpWord);
        $parser->parse();

        $parsed = $parser->getParsedQuestions();
        foreach ($parsed as $questionInfo) {
            /**
             * @var Question $question
             */
            $question = $test->nativeQuestions()
                ->create([
                    'question' => $questionInfo['question']
                ]);

            $question->answerOptions()
                ->createMany($questionInfo['insert_options']);
        }

        return redirect()->route('admin.tests.subject.test', [
            'subject' => $test->subject->uri_alias,
            'test'    => $test->uri_alias,
        ]);
    }
}
