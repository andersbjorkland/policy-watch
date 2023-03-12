<?php

declare(strict_types=1);

namespace App\Model\Parliament;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBBoolean;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\FieldType\DBInt;
use SilverStripe\ORM\FieldType\DBVarchar;

class Person extends DataObject
{
    private static string $table_name = 'ParliamentPerson';

    private static array $db = [
        'SourceID' => DBVarchar::class,
        'YearOfBirth' => DBInt::class,
        'Gender' => DBVarchar::class . '(6)',
        'Surname' => DBVarchar::class,
        'FirstName' => DBVarchar::class,
        'SortedName' => DBVarchar::class,
        'Constituency' => DBVarchar::class,
        'Status' => DBVarchar::class,
        'HasDiff' => DBBoolean::class,
        'DiffDated' => DBDatetime::class,
        'DiffExplanation' => DBVarchar::class
    ];

    private static array $has_one = [
        'Party' => Party::class,
        'Profile' => Image::class
    ];
}
