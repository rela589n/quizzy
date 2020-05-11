<?php

use App\Models\Department;
use App\Models\StudentGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str as Str;

class SetDepartmentIdOnGroups extends Seeder
{
    protected static $departmentsCorrelation = [
        'pi' => 1,
        'пі' => 1,
        'pr' => 1,
        'пр' => 1,

        'ki' => 2,
        'кі' => 2,
        'ks' => 2,
        'кс' => 2,

        'at' => 3,
        'ат' => 3,

        'ek' => 4,
        'ек' => 4,
        'me' => 4,
        'ме' => 4,

        'mg' => 5,
        'мг' => 5,
        'pm' => 5,
        'пм' => 5,
    ];

    /**
     * @var Collection
     */
    protected $departments = null;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->departments = Department::all();

        foreach (StudentGroup::withTrashed()->get() as $group) {

            if ($group->department()->exists()) {
                continue;
            }

            $department = $this->resolveDepartment($group->uri_alias);

            if ($department === null) {
                $department = $this->resolveDepartment($group->name);

                if ($department === null) {
                    $department = $this->departments->first();
                }
            }

            $group->department()->associate($department);
            $group->save();
        }
    }

    protected function resolveDepartment($field)
    {
        $department = null;

        foreach (self::$departmentsCorrelation as $key => $value) {
            $department = $this->tryResolve($field, $key);

            if ($department !== null) {
                break;
            }
        }

        return $department;
    }

    /**
     * @param $field
     * @param $val
     * @return Collection|Department|\Illuminate\Database\Eloquent\Model|null
     */
    protected function tryResolve($field, $val)
    {
        $field = mb_strtolower($field);
        $val = mb_strtolower($val);

        if (Str::contains($field, $val)) {
            return $this->departments->find(static::$departmentsCorrelation[$val]);
        }

        return null;
    }
}
