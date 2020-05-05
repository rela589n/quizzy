<?php

use App\Models\Course;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    protected static $courses = [
        [
            'numeric_name' => 1,
            'public_name'  => 'перший',
        ],
        [
            'numeric_name' => 2,
            'public_name'  => 'другий',
        ],
        [
            'numeric_name' => 3,
            'public_name'  => 'третій',
        ],
        [
            'numeric_name' => 4,
            'public_name'  => 'четвертий',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::insert(self::$courses);
    }
}
