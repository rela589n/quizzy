<?php

use App\Models\TestSubject;
use Illuminate\Database\Seeder;

class TestSubjectsTableSeeder extends Seeder
{
    protected static $subjects = [
        [
            'name'      => 'Політологія',
            'uri_alias' => 'politics',
            'course'    => 4
        ],
        [
            'name'      => 'ООП',
            'uri_alias' => 'oop',
            'course'    => 3
        ],
        [
            'name'      => 'Алгоритми',
            'uri_alias' => 'algorithms',
            'course'    => 2
        ],
        [
            'name'      => 'Основи програмування',
            'uri_alias' => 'programming-basics',
            'course'    => 1
        ]
    ];

    public static function getSubjectsCount()
    {
        return count(self::$subjects);
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

        TestSubject::insert(self::$subjects);
    }
}
