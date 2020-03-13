<?php


namespace App\Http\Controllers\Admin\Results;


use App\Http\Controllers\Admin\AdminController;
use App\Lib\Statements\StatementsGenerator;
use App\Lib\Statements\StudentStatementsGenerator;
use App\Models\TestResult;
use Illuminate\Http\Request;

class StatementsController extends AdminController
{
    /**
     * @param Request $request
     * @param StudentStatementsGenerator $generator
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \App\Exceptions\NullPointerException
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    public function studentStatement(Request $request, StudentStatementsGenerator $generator)
    {
        $result = TestResult::findOrFail($request->route('testResultId'));

        $generator->setResult($result);
        $statementPath = $generator->generate();

        return response()->download($statementPath);
    }
}
