<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com>.
//  Copyright. All rights reserved.
//

namespace App\BackEndBundle\Service;

use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeExtensionGuesser;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;


class Base64Service
{

    /** @var string */
    private $filePrefix;

    /**
     * @param string $base64
     * @param string $targetPath
     * @param string $filePrefix
     * @return string name of converted file
     */
    public function convertToFile(string $base64, string $targetPath, $availableFiles=[], $filePrefix = 'file_'): string
    {
        $this->filePrefix = $filePrefix;
        $fileName = $this->generateFileName();
        $filePath = $this->generateFilePath($targetPath, $fileName);

        $file = fopen($filePath, 'wb');
        $data = explode(',', $base64);
        fwrite($file, base64_decode($data[1]));
        fclose($file);

        $fileExt = $this->getFileExt($filePath);
        if(count($availableFiles) && !in_array($fileExt,$availableFiles)){
            throw new \Exception('Formato de archivo no válido');
        }
        rename($filePath, $filePath . '.' . $fileExt);

        return $fileName . '.' . $fileExt;
    }

    /**
     * @param string $targetPath
     * @param string $fileName
     * @return string
     */
    private function generateFilePath(string $targetPath, string $fileName): string
    {
        return $targetPath . '/' . $fileName;
    }

    /**
     * @return string
     */
    private function generateFileName(): string
    {
        return uniqid($this->filePrefix, true);
    }

    /**
     * @param string $filePath
     * @return string
     */
    private function getFileExt(string $filePath): string
    {
        $guesser = MimeTypeGuesser::getInstance();
        $extensionGuesser = new MimeTypeExtensionGuesser();

        return $extensionGuesser->guess(
            $guesser->guess($filePath)
        );
    }

}