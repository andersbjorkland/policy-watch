<?php

declare(strict_types=1);

namespace App\API;

use App\API\DataKey\PersonKey;
use App\API\DiffAnalyzer\PersonAnalyzer;
use App\Model\Parliament\Party;
use App\Model\Parliament\Person;
use GuzzleHttp\Client;
use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\FieldType\DBDatetime;

class ParliamentClient extends Client
{
    /** @config */
    private static $base_uri = '';

    public function __construct(){
        parent::__construct(
            [
                'base_uri' => Config::inst()->get(self::class, 'base_uri')
            ]
        );
    }

    /**
     * @return Person[]
     */
    public function getPersonList(): array
    {
        $list = [];
        $partyMap = $this->getPartyMap();

        $personDiffAnalyzer = new PersonAnalyzer();
        $downloader = new Downloader();

        $rawList = $this->getRawPersonList();
        foreach ($rawList as $rawPerson) {
            $sourceID = $rawPerson[PersonKey::SOURCE_ID];
            $partySign = strtolower($rawPerson[PersonKey::PARTY]);
            $party = $partyMap[$partySign] ?? null;

            /** @var ?Person $person */
            $person = Person::get_one(filter: ['SourceID' => $sourceID]);
            if ($person === null) {
                $person = new Person([
                    'SourceID' => $sourceID,
                    'YearOfBirth' => $rawPerson[PersonKey::BIRTH_YEAR],
                    'Gender' => $rawPerson[PersonKey::GENDER],
                    'Surname' => $rawPerson[PersonKey::SURNAME],
                    'FirstName' => $rawPerson[PersonKey::FIRST_NAME],
                    'SortedName' => $rawPerson[PersonKey::SORT_NAME],
                    'Constituency' => $rawPerson[PersonKey::CONSTITUENCY],
                    'Status' => $rawPerson[PersonKey::STATUS],
                    'ProfilePictureURL' => $rawPerson[PersonKey::PHOTO_URL]
                ]);

            } else {
                $diffs = $personDiffAnalyzer->getDiffKeys($person, $rawPerson);
                $hasDiff = strlen($diffs) > 0;
                if ($hasDiff) {
                    $person->HasDiff = $hasDiff;
                    $person->DiffDated = DBDatetime::now();
                    $person->DiffExplanation = $diffs;
                    $person->ProfilePictureURL = $rawPerson[PersonKey::PHOTO_URL];
                }

                if ($person->HasDiff && !$hasDiff) {
                    $person->HasDiff = $hasDiff;
                    $person->DiffDated = DBDatetime::now();
                    $person->DiffExplanation = $diffs;
                }
            }

            if ($party !== null && $person->PartyID == 0) {
                $person->Party = $party;
            }

//            if ($person->ProfilePictureID == 0) {
//                $pictureUrl = $rawPerson[PersonKey::PHOTO_URL];
//                $image = $downloader->downloadImage($pictureUrl);
//                $person->ProfilePicture = $image;
//            }

            $list[] = $person;
        }

        return $list;
    }



    public function getRawPersonList(): array
    {
        $list = [];
        $response = $this->get('/personlista/', [
            'query' => [
                'utformat' => 'json',
                'sort' => PersonKey::SORT_NAME,
                'sortorder' => 'asc'
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            return $list;
        }

        $content = $response->getBody()->getContents();
        $data = json_decode($content, true);

        return $data[PersonKey::PERSON_LIST][PersonKey::PERSONS] ?? [];
    }

    /**
     * @return array<string, Party>
     */
    public function getPartyMap(): array
    {
        $map = [];
        $parties = Party::get();
        /** @var Party $party */
        foreach ($parties as $party) {
            $sign = strtolower($party->Sign);
            $map[$sign] = $party;
        }

        return $map;
    }
}
