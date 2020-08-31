<?php


namespace App\Lib\Words;


use App\Lib\Words\Decliners\WordDeclinerInterface;
use App\Lib\Words\Repositories\WordsRepository;

class WordsManager
{
    private WordDeclinerInterface $wordDecliner;
    private WordsRepository $wordsRepository;

    public function __construct(WordDeclinerInterface $wordDecliner, WordsRepository $wordsRepository)
    {
        $this->wordDecliner = $wordDecliner;
        $this->wordsRepository = $wordsRepository;
    }

    public function decline($number, string $word): string
    {
        return $this->wordDecliner->decline(
            $number,
            $word,
            $this->wordsRepository->findEndings($word)
        );
    }
}
