<?php


namespace App\Services\Users\Administrators;


use App\Models\Administrator;

class CreateAdministratorService extends AdministratorService
{
    protected function doHandle(): Administrator
    {
        return Administrator::create($this->data);
    }
}
