<?php

namespace App\Actions\Csv;

class ProcessCsvFileAction
{
    public function __invoke($filePath)
    {
        return $filePath;
    }
}