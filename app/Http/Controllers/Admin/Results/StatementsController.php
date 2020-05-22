<?php


namespace App\Http\Controllers\Admin\Results;


use App\Http\Controllers\Admin\AdminController;
use App\Lib\Statements\GroupStatementsGenerator;
use App\Lib\Statements\StudentStatementsGenerator;
use App\Models\StudentGroup;
use App\Models\TestResult;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;

class StatementsController extends AdminController
{
    /**
     * @param Request $request
     * @param StudentStatementsGenerator $generator
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
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

    /**
     * @param Request $request
     * @param GroupStatementsGenerator $generator
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    public function groupStatement(Request $request, GroupStatementsGenerator $generator)
    {
        $group = StudentGroup::withTrashed()->findOrFail($request->input('groupId'));
        $test = $this->urlManager->getCurrentTest(true);

        $generator->setGroup($group);
        $generator->setTest($test);
        $generator->setTestResults($group->lastResults($test)->with([
            'askedQuestions.question'             => function (Relation $query) {
                $query->withTrashed();
            },
            'askedQuestions.answers.answerOption' => function (Relation $query) {
                $query->withTrashed();
            },
            'user'                                => function (Relation $query) {
                $query->withTrashed();
            },
            'user.studentGroup'                   => function (Relation $query) {
                $query->withTrashed();
            }
        ])->get());

        $statementPath = $generator->generate();

        return response()->download($statementPath);
    }
}
