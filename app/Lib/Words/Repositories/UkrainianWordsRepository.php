<?php


namespace App\Lib\Words\Repositories;


class UkrainianWordsRepository extends WordsRepository
{
    protected $wordEndings = [
        'бал' => ['', 'а', 'ів'],
        'студент' => ['', 'а', 'ів'],
    ];
}
