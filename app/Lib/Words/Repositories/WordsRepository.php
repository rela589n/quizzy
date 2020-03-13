<?php


namespace App\Lib\Words\Repositories;


abstract class WordsRepository
{
    /**
     * @var array
     */
    protected $wordEndings = [
        // 'word' => ['', 's']
    ];

    public function findEndings(string $word)
    {
        return $this->wordEndings[trim($word)] ?? [];
    }
}
