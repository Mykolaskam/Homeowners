<?php

namespace App\Actions\Csv;

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
                // Check if multiple people with "and"
                $people = self::getPeople($row);

                foreach ($people as $person) {
                    // Checking if person only has a title (data incomplete)
                    // Looking at the example CSV - this is the only case for "incomplete" data
                    $incomplete = str_word_count($person) === 1;

                    $title = self::getTitle($person);
                    $initial = $incomplete ? null : self::getInitial($person);
                    $firstName = $incomplete ? null : self::getFirstName($person, $initial);
                    $lastName = $incomplete ? self::getLastName($row) : self::getLastName($person);

                    $this->homeowners[] = [
                        "title" => $title,
                        "initial" => $initial,
                        "first_name" => $firstName,
                        "last_name" => $lastName
                    ];
                }
            }
        }

        return $this->homeowners;
    }

    private function getTitle($string)
    {
        // There will be more possible titles, but going ahead with the example CSV options
        preg_match('/(Mr|Mrs|Mister|Dr|Ms|Prof)\b/m', $string, $match);

        return $match[0] ?? null;
    }

    private function getFirstName($string, $initial): ?string
    {
        $array = explode(" ", $string);

        if (count($array) === 3 && $initial === null) {
            return $array[1];
        }

        return null;
    }

    private function getLastName($string): string
    {
        $array = explode(" ", $string);
        return end($array);
    }

    private function getInitial($string)
    {
        preg_match('/([A-Z][.]\s)|[A-Z]\s/m', $string, $match);
        return $match[0] ?? null;
    }

    private function getPeople($string): array
    {
        return preg_split('/ (&|and) /m', $string);
    }
}
