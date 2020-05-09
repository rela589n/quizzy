<?php

use App\Models\Department;
use App\Models\StudentGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr as Arr;

class GroupsTableSeeder extends Seeder
{
    protected static $groups = [
        'software-engineering' => [
            [
                'name'      => 'ПІ-191',
                'uri_alias' => 'example-pi-191',
                'year'      => '2019',
            ],
            [
                'name'      => 'ПІ-182',
                'uri_alias' => 'example-pi-182',
                'year'      => '2018',
            ],
            [
                'name'      => 'ПІ-171',
                'uri_alias' => 'example-pi-171',
                'year'      => '2017',
            ],
            [
                'name'      => 'ПІ-162',
                'uri_alias' => 'example-pi-162',
                'year'      => '2016',
            ],
        ]
    ];

    public static function getGroupsCount()
    {
        return count(self::$groups);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('APP_ENV') === 'production')
            return;

        foreach (self::$groups as $department => $groups) {
            $department = Department::whereUriAlias($department)->first();

            $department->studentGroups()->createMany($groups);
        }
    }
}
