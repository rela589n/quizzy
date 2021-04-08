<?php

namespace App\Nova\Actions;

use App\Models\StudentGroup;
use App\Models\User;
use App\Services\Users\ChangeGroupClassMonitor;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Webmozart\Assert\Assert;

class PromoteStudentToClassMonitor extends Action
{
    public $name = 'Зробити старостою';

    private ChangeGroupClassMonitor $service;
    private StudentGroup $group;

    public function __construct(StudentGroup $group)
    {
        $this->onlyOnIndex();

        $this->service = app()->make(ChangeGroupClassMonitor::class);
        $this->group = $group;
    }

    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        Assert::count($models, 1);

        /** @var User $student */
        $student = $models->first();
        Assert::isInstanceOf($student, User::class);

        ($this->service)($this->group, $student);
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
