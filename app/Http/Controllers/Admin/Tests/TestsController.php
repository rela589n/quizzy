<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestUrlManager;
use App\Http\Requests\Tests\CreateTestRequest;
use App\Test;
use Illuminate\Http\Request;

class TestsController extends Controller
{
    public function showNewTestForm()
    {
        return view('pages.admin.tests-new');
    }

    public function newTest(CreateTestRequest $request)
    {
        $tests = Test::find(1)->tests;

        $tests->load('nativeQuestions');

        foreach ($tests as $test) {
           dump($test->pivot->questions_quantity);
        }

        dd("Ok");
    }

    public function showUpdateSubjectForm(Request $request, RequestUrlManager $urlManager)
    {
        $test = $urlManager->getCurrentTest();

        return view('pages.admin.tests-single-settings', [
            'test' => $test
        ]);
    }
}
