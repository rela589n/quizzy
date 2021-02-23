<?php

declare(strict_types=1);


namespace App\Services\Users;

use App\Models\Administrator;
use App\Models\StudentGroup;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

final class ChangeGroupClassMonitor
{
    use AuthorizesRequests;

    private MakeUserClassMonitorAccount $createClassMonitorAccount;

    public function __construct(MakeUserClassMonitorAccount $createClassMonitorAccount)
    {
        $this->createClassMonitorAccount = $createClassMonitorAccount;
    }

    /**
     * @param  StudentGroup  $group
     * @param  User  $user
     *
     * @throws AuthorizationException
     */
    public function __invoke(StudentGroup $group, User $user)
    {
        $this->authorize('promoteToClassMonitor', $user);

        $account = Administrator::whereEmail($user->email)->first();

        if (null === $account) {
            $account = ($this->createClassMonitorAccount)($user);
        }

        $group->created_by = $account->id;
        $group->save();
    }
}
