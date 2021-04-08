<?php

namespace App\Policies;

use App\Models\Administrator;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdministratorPolicy
{
    use HandlesAuthorization;

    public function viewAny(Administrator $user): bool
    {
        return $user->can('view-administrators');
    }

    public function viewAll(Administrator $user): bool
    {
        return $user->can('view-all-administrators');
    }

    public function create(Administrator $administrator): bool
    {
        return $administrator->can('create-administrators');
    }

    public function view(Administrator $user, Administrator $model): bool
    {
        return (($this->viewAll($user)
                    || ($user->can('view-administrators')
                        && $model->isAvailableForAdmin($user)))
                && $this->isNotSystem($model))
            || $user->id === $model->id;
    }

    public function update(Administrator $user, Administrator $model): bool
    {
        return (($user->can('update-all-administrators')
                    || ($user->can('update-administrators')
                        && $model->isAvailableForAdmin($user)))
                && $this->isNotSystem($model))
            || $user->id === $model->id;
    }

    public function delete(Administrator $user, Administrator $model): bool
    {
        return ($user->can('delete-all-administrators')
                || ($user->can('delete-administrators')
                    && $model->isAvailableForAdmin($user)))
            && $this->isNotSystem($model)
            && $user->id !== $model->id;
    }

    public function forceDelete(Administrator $user, Administrator $model): bool
    {
        return $user->can('delete-all-administrators')
            && $this->isNotSystem($model);
    }

    private function isNotSystem(Administrator $administrator): bool
    {
        return $administrator->surname !== 'system';
    }
}
