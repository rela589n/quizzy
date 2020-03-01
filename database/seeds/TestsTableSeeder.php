<?php

use App\Models\TestComposite;
use Illuminate\Database\Seeder;

class TestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Test::create([
            'name' => 'Інкапсуляція',
            'uri_alias' => 'encapsulation',
            'time' => 20,
            'test_subject_id' => 1
        ]);

        TestComposite::create([
            'id_test' => 1,
            'id_include_test' => 1,
            'questions_quantity' => 999
        ]);
    }
}
