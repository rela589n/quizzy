<?php

namespace App\Http\Controllers\Admin;

class DocumentationController extends AdminController
{
    public const FILE_NAME = 'Інструкція.docx';

    public function getWordDocument()
    {
        return response()->download(
            resource_path('documentation/Teacher.docx'),
            self::FILE_NAME
        );
    }
}
