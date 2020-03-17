<?php


namespace App\Lib\Statements\FilePathGenerators;


abstract class ResultFileNameGenerator
{
    protected $storageDir = 'app/public/statements/';
    protected $filePrefix = 'Відомість';

    public function generate()
    {
         return storage_path(sprintf(
            '%s%s',
            $this->storageDir,
            $this->generateFileName()
        ));
    }

    abstract protected function generateFileName() : string;
}
