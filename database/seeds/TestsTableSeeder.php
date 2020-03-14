<?php

use App\Models\TestComposite;
use Illuminate\Database\Seeder;

class TestsTableSeeder extends Seeder
{
    public const TESTS_LIMIT = 6;

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

        $faker = Faker\Factory::create('uk_UA');

        foreach (range(2, self::TESTS_LIMIT) as $i) {
            \App\Models\Test::create([
                'name' => $faker->realText(15),
                'uri_alias' => $faker->unique()->slug(2),
                'time' => $faker->numberBetween(10, 30),
                'test_subject_id' => $faker->numberBetween(1, 2)
            ]);

            TestComposite::create([
                'id_test' => $i,
                'id_include_test' => $i,
                'questions_quantity' => 999
            ]);
        }
    }
}
