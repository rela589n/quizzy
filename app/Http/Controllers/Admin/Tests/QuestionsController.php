<?php

namespace App\Http\Controllers\Admin\Tests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function showCreateUpdateForm()
    {
        return view('pages.admin.tests-single');
    }

    public function createUpdate()
    {

    }
}
