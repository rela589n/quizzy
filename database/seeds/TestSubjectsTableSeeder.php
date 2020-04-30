<?php

use App\Models\TestSubject;
use Illuminate\Database\Seeder;

class TestSubjectsTableSeeder extends Seeder
{
    protected $subjects = [
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
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TestSubject::insert($this->subjects);
    }
}
