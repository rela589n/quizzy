<?php

use App\Models\TestComposite;
use App\Models\TestSubject;
use Illuminate\Database\Seeder;

class TestsTableSeeder extends Seeder
{
    public const TESTS_LIMIT = 200;

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

        $this->createRequired();

        $subjectsCount = TestSubjectsTableSeeder::getSubjectsCount();

        $faker = Faker\Factory::create('uk_UA');

        foreach (range(2, self::TESTS_LIMIT) as $i) {
            \App\Models\Test::create([
                'name' => $faker->realText(15),
                'uri_alias' => $faker->unique()->slug(2),
                'time' => $faker->numberBetween(10, 30),
                'test_subject_id' => $faker->numberBetween(1, $subjectsCount)
            ]);

            TestComposite::create([
                'id_test' => $i,
                'id_include_test' => $i,
                'questions_quantity' => 999
            ]);
        }
    }

    protected function createRequired(): void
    {
        /**
         * @var TestSubject $subject
         */
        $subject = TestSubject::where('uri_alias', 'oop')->first();

        /**
         * @var \App\Models\Test $test
         */
        $test = $subject->tests()->create([
            'name' => 'Інкапсуляція',
            'uri_alias' => 'encapsulation',
            'time' => 20,
        ]);

        TestComposite::create([
            'id_test' => $test->id,
            'id_include_test' => $test->id,
            'questions_quantity' => 999
        ]);
    }
}
