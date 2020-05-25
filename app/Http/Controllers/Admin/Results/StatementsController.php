<?php


namespace App\Http\Controllers\Admin\Results;


use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\FilterTestResultsRequest;
use App\Lib\Filters\Eloquent\TestResultFilter;
use App\Lib\Statements\GroupStatementsGenerator;
use App\Lib\Statements\StudentStatementsGenerator;
use App\Models\TestResult;
use App\Repositories\StudentGroupsRepository;
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
     * @param FilterTestResultsRequest $request
     * @param GroupStatementsGenerator $generator
     * @param TestResultFilter $filter
     * @param StudentGroupsRepository $groupsRepository
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    public function groupStatement(FilterTestResultsRequest $request,
                                   GroupStatementsGenerator $generator,
                                   TestResultFilter $filter,
                                   StudentGroupsRepository $groupsRepository)
    {
        $test = $this->urlManager->getCurrentTest(true);
        $group = $groupsRepository->withResultsOf($request->input('groupId'), $test->id);

        $generator->setGroup($group);
        $generator->setTest($test);

        $filter->setQueryFilters($request->getQueryFilters());
        $filter->setFilters($request->getFilters());

        $generator->setTestResults($group->lastResults($test)->filtered($filter));

        $statementPath = $generator->generate();

        return response()->download($statementPath);
    }
}
