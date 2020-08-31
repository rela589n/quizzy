<?php


namespace App\Lib\Words\Repositories;


class UkrainianWordsRepository extends WordsRepository
{
    protected array $wordEndings = [
        'бал'     => ['', 'а', 'ів'],
        'студент' => ['', 'а', 'ів'],
        'відсот'  => ['ок', 'ка', 'ків'],
    ];
}
