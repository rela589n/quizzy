<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    protected static array $courses = [
        [
            'id'          => 1,
            'public_name' => 'перший',
        ],
        [
            'id'          => 2,
            'public_name' => 'другий',
        ],
        [
            'id'          => 3,
            'public_name' => 'третій',
        ],
        [
            'id'          => 4,
            'public_name' => 'четвертий',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Course::insert(self::$courses);
    }
}
