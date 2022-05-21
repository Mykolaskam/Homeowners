<?php

namespace App\Actions\Csv;

use App\Homeowner\Homeowner;

class ProcessCsvFileAction
{

    /**
     * Using the test CSV file, the result "Mrs Joe Bloggs" didn't look right.
     * After some research it's found that the etiquette after marriage is that
     * the "Mrs" takes "his" full name. The correct result would be "Mrs Bloggs" and "Dr Joe Bloggs"
     *
     * After some more research it's been found that titles have a formality of their order.
     * "Mr & Dr" - would be incorrect. "Dr & Mr" - would be correct. The first and last name would belong to the "Mr".
     * However, not due to his "rank", but because his name is the "lead" in marriage.
     *
     * I feel that this consideration and all the different possibilities would be outside the scope of this task.
     */

    private array $homeowners;

    public function __construct()
    {
        $this->homeowners = [];
    }

    public function __invoke($filePath): array
    {
        // Get CSV rows as array without storing the file in the filesystem
        // Should be converted to a job to process larger files
        $rows = str_getcsv(file_get_contents($filePath));

        foreach ($rows as $rowIndex => $row) {
            // We'll assume that all files will have a header row for this task
            if ($rowIndex !== 0) {

                // Split the row into individual people
                $people = self::getPeople($row);

                foreach ($people as $person) {
                    $homeowner = new Homeowner($person, $people);
                    $this->homeowners[] = $homeowner->getHomeowner();
                }
            }
        }

        return $this->homeowners;
    }

    private function getPeople($string): array
    {
        return preg_split('/ (&|and) /m', $string);
    }
}
