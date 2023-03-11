<?php

declare(strict_types=1);

namespace App\Model\Parliament;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\FieldType\DBInt;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\FieldType\DBVarchar;

class Mission extends DataObject
{
    private static string $table_name = 'ParliamentMission';

    private static array $db = [
        'code' => DBText::class,
        'order' => DBInt::class,
        'name' => DBText::class,
        'type' => DBVarchar::class . '(20)',
        'status' => DBVarchar::class . '(20)',
        'duration_from' => DBDatetime::class,
        'duration_to' => DBDatetime::class,
        'description' => DBText::class
    ];

    private static array $has_one = [
        'body'=> Body::class
    ];

}
