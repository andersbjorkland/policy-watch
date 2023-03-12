<?php

declare(strict_types=1);

namespace App\API;

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
}
