<?php

declare(strict_types=1);

namespace App\Model\Parliament;

use SilverStripe\ORM\FieldType\DBInt;
use SilverStripe\ORM\FieldType\DBText;

class Body extends \SilverStripe\ORM\DataObject
{
    private static string $table_name = 'parliament_body';

    private static array $db = [
        'code' => DBText::class,
        'name' => DBText::class,
        'type' => DBText::class,
        'order' => DBInt::class,
        'name_en' => DBText::class,
        'domain' => DBText::class,
        'description' => DBText::class
    ];

}
