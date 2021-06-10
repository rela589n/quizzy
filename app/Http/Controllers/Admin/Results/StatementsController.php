<?php


namespace App\Http\Controllers\Admin\Results;


use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\FilterTestResults\GroupStatementByFiltersRequest;
use App\Lib\Filters\Eloquent\TestResultFilter;
use App\Lib\Statements\GroupStatementsGenerator;
use App\Lib\Statements\StudentStatementsGenerator;
use App\Models\TestResult;
use App\Repositories\StudentGroupsRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\Exception\Exception as PhpWordException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class StatementsController extends AdminController
{
    /**
     * @param  Request  $request
     * @param  StudentStatementsGenerator  $generator
     * @return BinaryFileResponse
     * @throws CopyFileException
     * @throws CreateTemporaryFileException
     * @throws PhpWordException
     */
    public function studentStatement(Request $request, StudentStatementsGenerator $generator): BinaryFileResponse
    {
        /** @var TestResult $result */
        $result = TestResult::query()->withResultPercents()->findOrFail($request->route('testResultId'));

        $generator->setResult($result);
        $statementPath = $generator->generate();

        return response()->download($statementPath);
    }

    /**
     * @param  GroupStatementByFiltersRequest  $request
     * @param  GroupStatementsGenerator  $generator
     * @param  TestResultFilter  $filter
     * @param  StudentGroupsRepository  $groupsRepository
     * @return BinaryFileResponse
     * @throws CopyFileException
     * @throws CreateTemporaryFileException
     * @throws PhpWordException
     * @throws BindingResolutionException
     */
    public function groupStatement(GroupStatementByFiltersRequest $request,
                                   GroupStatementsGenerator $generator,
                                   TestResultFilter $filter,
                                   StudentGroupsRepository $groupsRepository): BinaryFileResponse
    {
        $test = $this->urlManager->getCurrentTest(true);
        $group = $groupsRepository->whereHasResultsOf($request->input('groupId'), $test->id);

        $generator->setGroup($group);
        $generator->setTest($test);

        $filter->setQueryFilters($request->getQueryFilters());
        $filter->setFilters($request->getFilters());

        $generator->setTestResults(
            $group->lastResults($test)->withResultPercents()->filtered($filter)
        );

        $statementPath = $generator->generate();

        return response()->download($statementPath);
    }
}
