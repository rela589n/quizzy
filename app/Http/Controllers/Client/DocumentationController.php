<?php

namespace App\Http\Controllers\Client;

class DocumentationController extends ClientController
{
    const FILE_NAME = 'Інструкція.docx';

    public function getWordDocument()
    {
        return response()->download(
            resource_path('storage/documentation/Student.docx'),
            self::FILE_NAME
        );
    }
}
