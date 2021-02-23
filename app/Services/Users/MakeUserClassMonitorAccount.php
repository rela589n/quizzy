<?php

declare(strict_types=1);


namespace App\Services\Users;

use App\Models\Administrator;
use App\Models\User;
use App\Services\Users\Administrators\CreateAdministratorService;
use Spatie\Permission\Models\Role;

final class MakeUserClassMonitorAccount
{
    private CreateAdministratorService $service;

    public function __construct(CreateAdministratorService $createAdministratorService)
    {
        $this->service = $createAdministratorService;
    }

    public function __invoke(User $user): Administrator
    {
        if (Administrator::whereEmail($user->email)->exists()) {
            throw new \InvalidArgumentException("Administrator with email {$user->email} already exists");
        }

        return $this->service
            ->withoutPasswordHashing()
            ->handle(
                [
                    'name'       => $user->name,
                    'surname'    => $user->surname,
                    'patronymic' => $user->patronymic,
                    'email'      => $user->email,
                    'password'   => $user->password,
                    'role_ids'   => [Role::query()->where('name', 'class-monitor')->first('id')->id]
                ]
            );
    }
}
