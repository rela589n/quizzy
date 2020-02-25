<?php


namespace App\Models;


class Admin extends User
{
    // mock implementation of admins auth
    protected $table = 'users';
}
