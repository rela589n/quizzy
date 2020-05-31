<?php


namespace App\Services\Users\Administrators;


use App\Models\Administrator;

class UpdateAdministratorService extends AdministratorService
{
    /**
     * @param Administrator $administrator
     * @return self
     */
    public function setAdministrator(Administrator $administrator): self
    {
        $this->administrator = $administrator;

        return $this;
    }

    protected function doHandle(): Administrator
    {
        return tap($this->administrator)->update($this->data);
    }
}
