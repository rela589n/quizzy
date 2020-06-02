<?php

namespace App\Http\Controllers\Admin;

class DocumentationController extends AdminController
{
    const FILE_NAME = 'Інструкція.docx';

    public function getWordDocument()
    {
        return response()->download(
            resource_path('storage/documentation/Teacher.docx'),
            self::FILE_NAME
        );
    }
}
