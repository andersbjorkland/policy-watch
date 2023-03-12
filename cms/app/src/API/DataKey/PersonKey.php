<?php

declare(strict_types=1);

namespace App\API\DataKey;
class PersonKey
{
    public const PERSON_LIST = 'personlista';
    public const PERSONS = 'person';
    public const SOURCE_ID = 'sourceid';
    public const BIRTH_YEAR = 'fodd_ar';
    public const GENDER = 'gender';
    public const SURNAME = 'efternamn';
    public const FIRST_NAME = 'tilltalsnamn';
    public const SORT_NAME = 'sorteringsnamn';
    public const PARTY = 'parti';
    public const CONSTITUENCY = 'valkrets';
    public const STATUS = 'status';
    public const PHOTO_URL = 'bild_url_max';
    public const PERSONAL_TASK = 'personuppdrag';

    public static function getDataKeys(): array
    {
        $reflection = new \ReflectionClass(static::class);

        return $reflection->getConstants(\ReflectionProperty::IS_PUBLIC);
    }
}
