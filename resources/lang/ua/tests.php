<?php

use App\Models\Questions\QuestionType;
use App\Models\Test;

return [
    'strategies' => [
        Test::DISPLAY_ALL => 'Всі питання одразу',
        Test::DISPLAY_ONE_BY_ONE => 'По одному питанню',
    ],
    'questions' => [
        'types' => [
            (string)QuestionType::CHECKBOXES() => 'Прапорці',
            (string)QuestionType::RADIO() => 'Перемикачі',
        ],
    ]
];
