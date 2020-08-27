<?php


namespace App\Services\Users\Administrators;


use App\Models\Administrator;
use Illuminate\Support\Facades\Hash;

abstract class AdministratorService
{
    protected array $data;
    protected bool $needPasswordHash = true;

    /**
     * @param bool $needPasswordHash
     * @return $this
     */
    public function setNeedPasswordHash(bool $needPasswordHash): self
    {
        $this->needPasswordHash = $needPasswordHash;

        return $this;
    }

    /**
     * @return $this
     */
    public function withPasswordHashing(): self
    {
        $this->setNeedPasswordHash(true);

        return $this;
    }

    /**
     * @return $this
     */
    public function withoutPasswordHashing(): self
    {
        $this->setNeedPasswordHash(false);

        return $this;
    }

    protected Administrator $administrator;

    public function handle(array $data): Administrator
    {
        $this->data = $data;
        $this->prepareData();

        $this->administrator = $this->doHandle();
        $this->syncRoles();

        return $this->administrator;
    }

    protected function prepareData(): void
    {
        if ($this->needPasswordHash) {
            $this->data['password'] = Hash::make($this->data['password']);
        }
    }

    protected function syncRoles(): void
    {
        $this->administrator->syncRoles($this->data['role_ids']);
    }

    abstract protected function doHandle(): Administrator;
}
