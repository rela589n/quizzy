<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends AdminController
{
    public function showUsersTypeList()
    {
        return view('pages.admin.user-types-list', [
            'teachersCount' => Administrator::query()->count(),
            'studentsCount' => User::query()->count()
        ]);
    }
    //admin
}
