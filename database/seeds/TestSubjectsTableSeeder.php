<?php

use App\Models\TestSubject;
use Illuminate\Database\Seeder;

class TestSubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TestSubject::create([
            'name' => 'ООП',
            'uri_alias' => 'oop',
            'course' => 3
        ]);

        TestSubject::create([
            'name' => 'Алгоритми',
            'uri_alias' => 'algorithms',
            'course' => 2
        ]);
    }
}
