<?php

namespace App\Http\Controllers;

use App\Actions\Csv\ProcessCsvFileAction;
use App\Http\Requests\Csv\CsvRequest;
use Inertia\Inertia;

class CsvController extends Controller
{
    public function __invoke(CsvRequest $request, ProcessCsvFileAction $processCsvFileAction)
    {
        // Pass in validated CSV file into the action
        $response = $processCsvFileAction($request->validated()['file']->path());

//        dd($response);

        return Inertia::render('Dashboard');
    }
}
