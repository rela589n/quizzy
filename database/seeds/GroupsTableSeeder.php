<?php

use App\Models\StudentGroup;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    public const GROUPS_LIMIT = 4;

    protected $groups = [
        [
            'name' => 'ПІ-182',
            'uri_alias' => 'example-pi-182',
            'year' => '2018'
        ],
        [
            'name' => 'ПІ-171',
            'uri_alias' => 'example-pi-171',
            'year' => '2017'
        ],
        [
            'name' => 'ПІ-161',
            'uri_alias' => 'example-pi-161',
            'year' => '2016'
        ],
        [
            'name' => 'ПІ-162',
            'uri_alias' => 'example-pi-162',
            'year' => '2016'
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentGroup::insert($this->groups);
    }
}
