<?php

use App\Models\Course;
use App\Models\TestSubject;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    protected static $courses = [
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
    public function run()
    {
        Course::insert(self::$courses);

        if (env('APP_ENV') === 'production') {
            /**
             * @var TestSubject[] $subjects
             */
            $subjects = TestSubject::all();

            foreach ($subjects as $subject) {
                $subject->courses()->sync([$subject->course], false);
            }
        }
    }
}
