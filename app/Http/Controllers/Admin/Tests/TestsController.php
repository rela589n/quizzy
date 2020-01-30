<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Controller;
use App\Test;
use Illuminate\Http\Request;

class TestsController extends Controller
{
    public function showAll(Request $request)
    {
        $tests = Test::with('subject')
            ->withCount('nativeQuestions as questions_count')
            ->get();

        return view('pages.admin.subjects-single', [
            'tests' => $tests
        ]);
    }

}
