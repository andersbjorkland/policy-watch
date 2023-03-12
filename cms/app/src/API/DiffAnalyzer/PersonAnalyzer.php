<?php

declare(strict_types=1);

namespace App\API\DiffAnalyzer;

use App\API\DataKey\PersonKey;
use App\Model\Parliament\Person;

class PersonAnalyzer
{
    public function getDiffKeys(Person $person, array $rawPerson): string
    {
        $differences = [];
        if ($rawPerson[PersonKey::BIRTH_YEAR] != $person->YearOfBirth) {
            $differences[] = 'YearOfBirth';
        }

        if ($rawPerson[PersonKey::GENDER] != $person->Gender) {
            $differences[] = 'Gender';
        }

        if ($rawPerson[PersonKey::SURNAME] != $person->Surname) {
            $differences[] = 'Surname';
        }

        if ($rawPerson[PersonKey::FIRST_NAME] != $person->FirstName) {
            $differences[] = 'FirstName';
        }

        if ($rawPerson[PersonKey::SORT_NAME] != $person->SortedName) {
            $differences[] = 'SortedName';
        }

        if ($rawPerson[PersonKey::CONSTITUENCY] != $person->Constituency) {
            $differences[] = 'Constituency';
        }

        if ($rawPerson[PersonKey::STATUS] != $person->Status) {
            $differences[] = 'Status';
        }

        if ($rawPerson[PersonKey::PARTY] != $person->Party?->Sign) {
            $differences[] = 'Party';
        }

        if (empty($differences)) {
            return '';
        }

        // Return a string of all differences detected
        return implode("\n", $differences);
    }
}
