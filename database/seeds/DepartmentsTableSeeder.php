<?php

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    protected static array $departments = [
        [
            'name'      => 'Програмна Інженерія',
            'uri_alias' => 'software-engineering',
        ],
        [
            'name'      => 'Комп\'ютерна Інженерія',
            'uri_alias' => 'computer-engineering',
        ],
        [
            'name'      => 'Автомобільний Транспорт',
            'uri_alias' => 'automobile-transport',
        ],
        [
            'name'      => 'Економіка та Менеджмент',
            'uri_alias' => 'economics-and-management',
        ],
        [
            'name'      => 'Інженерна Механіка',
            'uri_alias' => 'engineering-mechanics',
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Department::insert(self::$departments);
    }
}
