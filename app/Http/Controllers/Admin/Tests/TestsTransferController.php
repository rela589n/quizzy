<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\Tests\Transfers\ImportTestRequest;
use App\Lib\Parsers\TestParserFactory;
use App\Lib\Statements\TestsExportManager;
use App\Lib\Tests\TestImportService;
use App\Models\Question;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\Exception\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TestsTransferController extends AdminController
{
    /**
     * @return View
     * @throws AuthorizationException
     */
    public function showImportForm(): View
    {
        $test = $this->urlManager->getCurrentTest();
        $this->authorize('update', $test);

        $subject = $this->urlManager->getCurrentSubject();

        return view('pages.admin.tests-import', compact('subject', 'test'));
    }

    public function import(
        ImportTestRequest $request,
        TestParserFactory $parserFactory
    ): RedirectResponse {
        $test = $this->urlManager->getCurrentTest();
        $file = $request->file('selected-file');

        $service = new TestImportService($test);
        $service->import($parserFactory->getTextParser($file));

        return redirect()->route(
            'admin.tests.subject.test',
            [
                'subject' => $test->subject->uri_alias,
                'test'    => $test->uri_alias,
            ]
        );
    }

    /**
     * @param  TestsExportManager  $exportManager
     * @return BinaryFileResponse
     * @throws CopyFileException
     * @throws CreateTemporaryFileException
     * @throws Exception
     */
    public function export(TestsExportManager $exportManager): BinaryFileResponse
    {
        $exportManager->setTest($this->urlManager->getCurrentTest());

        $exportedPath = $exportManager->generate();

        return response()->download($exportedPath);
    }
}
