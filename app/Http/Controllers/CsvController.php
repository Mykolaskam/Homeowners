<?php

namespace App\Http\Controllers;

use App\Actions\Csv\ProcessCsvFileAction;
use App\Http\Requests\Csv\CsvRequest;
use Inertia\Inertia;
use Inertia\Response;

class CsvController extends Controller
{
    public function __invoke(CsvRequest $request, ProcessCsvFileAction $processCsvFileAction): Response
    {
        // Pass in validated CSV file into the action
        $homeowners = $processCsvFileAction($request->validated()['file']->path());

        return Inertia::render('Dashboard', [
            "homeowners" => $homeowners
        ]);
    }
}
