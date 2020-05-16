<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Tests\Transfers\ImportTestRequest;
use App\Lib\Parsers\TestParserFactory;
use App\Lib\Statements\TestsExportManager;
use App\Models\Question;

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
     * @param TestParserFactory $parserFactory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(ImportTestRequest $request, TestParserFactory $parserFactory)
    {
        $test = $this->urlManager->getCurrentTest();
        $file = $request->file('selected-file');

        $parser = $parserFactory->getTextParser($file);
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

    /**
     * @param TestsExportManager $exportManager
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    public function export(TestsExportManager $exportManager)
    {
        $exportManager->setTest($this->urlManager->getCurrentTest());

        $exportedPath = $exportManager->generate();

        return response()->download($exportedPath);
    }
}
