<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        DB::disableQueryLog();

        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);

        $this->call(DepartmentsTableSeeder::class);
        $this->call(GroupsTableSeeder::class);

        $this->call(UsersTableSeeder::class);
        $this->call(AdministratorsTableSeeder::class);

        $this->call(CoursesTableSeeder::class);
        $this->call(TestSubjectsTableSeeder::class);
        $this->call(TestsTableSeeder::class);

        $this->call(QuestionsTableSeeder::class);
        $this->call(AnswerOptionsTableSeeder::class);

        $this->call(TestResultsTableSeeder::class);
        $this->call(AskedQuestionsTableSeeder::class);
        $this->call(AnswersTableSeeder::class);
    }
}
