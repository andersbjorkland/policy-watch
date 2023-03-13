<?php

declare(strict_types=1);

namespace App\API;

use App\Model\Parliament\Person;
use GuzzleHttp\Client;
use SilverStripe\Assets\Folder;
use SilverStripe\Assets\Image;
use SilverStripe\Control\Director;
use SilverStripe\ORM\ValidationException;

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

    /**
     * @throws \Throwable
     * @throws ValidationException
     */
    public function downloadImageBatch($people): bool
    {
        $promises = [];
        $persons = [];
        $client = new Client();

        $assetsPath  = 'Parliament';
        $parliamentFolder = Folder::find_or_make($assetsPath);

        /** @var Person $person */
        foreach ($people as $person) {
            if ($person->ProfilePictureID !== null) {
                continue;
            }

            $promises[$person->SourceID] = $client->getAsync($person->ProfilePictureURL);
            $persons[$person->SourceID] = $person;
        }

        echo 'Requests: ' . count($promises) . PHP_EOL;

        $results = \GuzzleHttp\Promise\Utils::unwrap($promises);
        foreach ($results as $sourceId => $response) {
            echo 'Storing for ' . $sourceId . PHP_EOL;
            $imageContents = $response->getBody()->getContents();
            $filename = $assetsPath . "/$sourceId.jpg";
            $person = $persons[$sourceId];
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
