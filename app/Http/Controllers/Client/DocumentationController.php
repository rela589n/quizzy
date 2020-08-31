<?php

namespace App\Http\Controllers\Client;

class DocumentationController extends ClientController
{
    public const FILE_NAME = 'Інструкція.docx';

    public function getWordDocument()
    {
        return response()->download(
            resource_path('documentation/Student.docx'),
            self::FILE_NAME
        );
    }
}
