<?php

declare(strict_types=1);

namespace App\API;

use App\Model\Parliament\Person;
use GuzzleHttp\Client;
use SilverStripe\Assets\Folder;
use SilverStripe\Assets\Image;
use SilverStripe\Control\Director;

class Downloader
{
    public function downloadImage(string $fileUrl): ?Image
    {
        $fileName = pathinfo($fileUrl, PATHINFO_BASENAME);

        $filePath = Director::publicFolder() . '/assets/.protected/Downloads/' . $fileName;

        // Download file from URL
        file_put_contents($filePath, fopen($fileUrl, 'r'));

        // Save file to assets
        $file = new Image();
        $file->Name = $fileName;
        $file->setFromLocalFile($filePath);
        $file->write();

        // Delete temporary file
        unlink($filePath);

        return $file;
    }

    public function downloadImageBatch($people): bool
    {
        $promises = [];
        $persons = [];
        $client = new Client();

        $assetsPath  = Director::publicFolder() . '/assets/';
        $parliamentFolder = Folder::find_or_make('Parliament', $assetsPath);

        /** @var Person $person */
        foreach ($people as $person) {
            $promises[$person->ID] = $client->getAsync($person->ProfilePictureURL);
            $persons[$person->ID] = $person;
        }

        echo 'Requests: ' . count($promises) . PHP_EOL;

        $results = \GuzzleHttp\Promise\Utils::unwrap($promises);
        foreach ($results as $personId => $response) {
            echo 'Storing for ' . $personId . PHP_EOL;
            $imageContents = $response->getBody()->getContents();
            $filename = "person-$personId.jpg";
            $person = $persons[$personId];
            $file = new Image();
            $file->setFromString($imageContents, $filename);
            $file->ParentID = $parliamentFolder->ID;
            $file->setFilename($filename);
            $file->write();

            $person->ProfilePicture = $file;
        }

        return true;
    }
}
