<?php

declare(strict_types=1);

namespace App\API;

use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;

class Downloader
{
    public function downloadImage(string $fileUrl): ?Image
    {
        $fileName = pathinfo($fileUrl, PATHINFO_BASENAME);
        $filePath = 'assets/files/' . $fileName;
        $fileType = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $fileUrl);

        // Check if the file type is allowed
        $allowed_types = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
        if (!in_array($fileType, $allowed_types)) {
            echo 'File type not allowed';
            return null;
        }

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
