<?php

declare(strict_types=1);

namespace App\Model\Parliament;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBVarchar;

class Party extends DataObject
{
    private static string $table_name = 'ParliamentParty';

    private static array $db = [
        'Sign' => DBVarchar::class . '(4)',
        'Name' => DBVarchar::class
    ];

    private static array $has_many = [
        'Members' => Person::class
    ];
}
