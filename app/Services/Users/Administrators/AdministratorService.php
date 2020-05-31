<?php


namespace App\Services\Users\Administrators;


use App\Models\Administrator;
use Illuminate\Support\Facades\Hash;

abstract class AdministratorService
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var bool
     */
    protected $needPasswordHash = true;

    /**
     * @param bool $needPasswordHash
     * @return self
     */
    public function setNeedPasswordHash(bool $needPasswordHash): self
    {
        $this->needPasswordHash = $needPasswordHash;

        return $this;
    }

    public function withPasswordHashing()
    {
        $this->setNeedPasswordHash(true);

        return $this;
    }

    public function withoutPasswordHashing()
    {
        $this->setNeedPasswordHash(false);

        return $this;
    }

    /**
     * @var Administrator
     */
    protected $administrator;

    public function handle(array $data): Administrator
    {
        $this->data = $data;
        $this->prepareData();

        $this->administrator = $this->doHandle();
        $this->syncRoles();

        return $this->administrator;
    }

    protected function prepareData()
    {
        if ($this->needPasswordHash) {
            $this->data['password'] = Hash::make($this->data['password']);
        }
    }

    protected function syncRoles()
    {
        $this->administrator->syncRoles($this->data['role_ids']);
    }

    protected abstract function doHandle(): Administrator;
}
