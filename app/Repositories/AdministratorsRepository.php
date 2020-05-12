<?php


namespace App\Repositories;


use App\Lib\Filters\Eloquent\ClassMonitorsFilter;
use App\Models\Administrator;
use App\Models\StudentGroup;

class AdministratorsRepository
{
    protected $classMonitorFilters;

    public function __construct(ClassMonitorsFilter $classMonitorFilters)
    {
        $this->classMonitorFilters = $classMonitorFilters;
    }

    public function probableClassMonitors(StudentGroup $group = null)
    {
        $this->classMonitorFilters->setGroup($group);

        $classMonitors = Administrator::ofRole('class-monitor');
        $classMonitors = $classMonitors->filtered($this->classMonitorFilters);

        return $classMonitors;
    }
}
