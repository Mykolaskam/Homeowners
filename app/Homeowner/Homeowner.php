<?php

namespace App\Homeowner;

class Homeowner
{
    private string $person;
    private array $relatedPeople;

    public function __construct($person, $people = [])
    {
        $this->person = $person;
        $this->relatedPeople = $people;
    }

    public function getHomeowner(): array
    {
        return [
            "title" => self::getTitle(),
            "initial" => self::getInitial(),
            "first_name" => self::getFirstName(),
            "last_name" => self::getLastName()
        ];
    }

    public function getTitle(): string|null
    {
        // There will be more possible titles, but going ahead with the example CSV options
        preg_match('/(Mr|Mrs|Mister|Dr|Ms|Prof)\b/m', $this->person, $match);

        return $match[0] ?? null;
    }

    public function getInitial(): string|null
    {
        // "X. " or "X " would match
        preg_match('/([A-Z][.]\s)|[A-Z]\s/m', $this->person, $match);
        return $match[0] ?? null;
    }

    public function getFirstName(): string|null
    {
        $words = [];

        if (self::isNameHolder()) {
            $words = explode(" ", end($this->relatedPeople));
        }

        if (self::carriesOwnName()) {
            $words = explode(" ", $this->person);
        }

        return count($words) === 3 && self::getInitial() === null ? $words[1] : null;
    }

    public function getLastName(): string|null
    {
        if (self::isNameHolder()) {
            $words = explode(" ", end($this->relatedPeople));
            return end($words);
        } else {
            $words = explode(" ", $this->person);
            return end($words);
        }
    }

    public function isNameHolder(): string|null
    {
        if (str_word_count($this->person) === 1) {
            return true;
        }

        return false;
    }

    public function carriesOwnName(): string|null
    {
        foreach ($this->relatedPeople as $person) {
            if (str_word_count($person) === 1) {
                return false;
            }
        }

        return true;
    }
}
