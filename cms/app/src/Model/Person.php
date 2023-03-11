<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Parliament\Party;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBInt;
use SilverStripe\ORM\FieldType\DBVarchar;

class Person extends DataObject
{
    private static string $table_name = 'Person';

    private static array $db = [
        'yearOfBirth' => DBInt::class,
        'gender' => DBVarchar::class . '(6)',
        'surname' => DBVarchar::class,
        'firstName' => DBVarchar::class,
        'sortedName' => DBVarchar::class,
        'constituency' => DBVarchar::class,
        'status' => DBVarchar::class
    ];

    private static array $has_one = [
        'party' => Party::class,
        'profile' => Image::class
    ];
}
