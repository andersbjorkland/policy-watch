<?php

declare(strict_types=1);

namespace App\Model\Parliament;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBBoolean;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\FieldType\DBInt;
use SilverStripe\ORM\FieldType\DBVarchar;

/**
 * @property mixed|null $YearOfBirth
 * @property string|null $Gender
 * @property string|null $Surname
 * @property string|null $FirstName
 * @property string|null $SortedName
 * @property string|null $Constituency
 * @property string|null $Status
 * @property bool|mixed|null $HasDiff
 * @property mixed|DBDatetime|null $DiffDated
 * @property string|null $DiffExplanation
 * @property Party|null $Party
 * @property int|null $PartyID
 * @property mixed|null $ProfilePictureID
 * @property mixed|\SilverStripe\Assets\Image|null $ProfilePicture
 * @property mixed|null $ProfilePictureURL
 */
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
        'DiffExplanation' => DBVarchar::class,
        'ProfilePictureURL' => DBVarchar::class
    ];

    private static array $has_one = [
        'Party' => Party::class,
        'ProfilePicture' => Image::class
    ];

    private static array $summary_fields = [
        'ProfilePicture.CMSThumbnail' => 'Profile',
        'FirstName',
        'Surname',
        'Party.Name' => 'Party'
    ];
}
