<?php

use App\Models\TestSubject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class TestSubjectsTableSeeder extends Seeder
{
    protected static array $subjects = [
        [
            'name'             => 'Політологія',
            'uri_alias'        => 'politics',
            'sync_courses'     => 4,
            'sync_departments' => 1,
        ],
        [
            'name'             => 'ООП',
            'uri_alias'        => 'oop',
            'sync_courses'     => 3,
            'sync_departments' => 1,
        ],
        [
            'name'             => 'Алгоритми',
            'uri_alias'        => 'algorithms',
            'sync_courses'     => 2,
            'sync_departments' => 1,
        ],
        [
            'name'             => 'Основи програмування',
            'uri_alias'        => 'programming-basics',
            'sync_courses'     => 1,
            'sync_departments' => 1,
        ]
    ];

    public static function getSubjectsCount(): int
    {
        return count(self::$subjects);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        if (env('APP_ENV') === 'production') {
            return;
        }

        foreach (self::$subjects as $subjectInfo) {
            $subject = TestSubject::create(Arr::only($subjectInfo, ['name', 'uri_alias']));

            $subject->courses()->sync($subjectInfo['sync_courses']);
            $subject->departments()->sync($subjectInfo['sync_departments']);
        }
    }
}
