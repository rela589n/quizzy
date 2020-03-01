<?php

use App\Models\AnswerOption;
use Illuminate\Database\Seeder;

class AnswerOptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnswerOption::create([
            'text' => 'це спеціальна конструкція, яка використовується для групування пов\'язаних змінних та функцій.',
            'question_id' => 1,
            'is_right' => true
        ]);

        AnswerOption::create([
            'text' => 'це функція, що дає змогу отримати значення глобальних змінних.',
            'question_id' => 1,
            'is_right' => false
        ]);

        AnswerOption::create([
            'text' => 'це макет, по якому можна створювати об\'єкти.',
            'question_id' => 1,
            'is_right' => true
        ]);
    }
}
