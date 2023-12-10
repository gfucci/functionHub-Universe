<?php

//extensions example
$extensions = [
    'jpg',
    'jpeg',
    'JPG',
    'png',
    'PNG'
];

function convertAllImagesFromFoldersToWEBP(
    string $folderPath, 
    array $extensions, 
    int $qualityImage, 
    int $newWidth, 
    int $newHeight
): void
{
    ini_set('memory_limit', '-1');

    $folder = glob($folderPath . '/*');

    foreach ($folder as $key => $folderFile) {
        if (!is_dir($folderFile)) {
            $path_parts = pathinfo($folderFile);
    
            if(array_key_exists('extension', $path_parts) && in_array($path_parts['extension'], $extensions)) {
                $imagePath = $path_parts['dirname'] . "/" . $path_parts["basename"];
                $newImageName = str_replace($path_parts['extension'], 'webp', $path_parts["basename"]);
                $newImagePath = $path_parts['dirname'] . "/" . $newImageName;

                list($originalWidth, $originalHeight) = getimagesize($imagePath);

                $originalRatio = $originalWidth / $originalHeight;
                $desiredRatio = $newWidth / $newHeight;

                if ($originalRatio > $desiredRatio) {
                    $adjustedWidth = $newWidth;
                    $adjustedHeight = $newWidth / $originalRatio;
                } else {
                    $adjustedWidth = $newHeight * $originalRatio;
                    $adjustedHeight = $newHeight;
                }

                if (filesize($folderFile) === 0) {
                    unlink($folderFile);
                    echo "Arquivo corrompido deletado: $folderFile";
                    continue;
                }

                $image_p = imagecreatetruecolor($adjustedWidth, $adjustedHeight);
                
                if (
                    $path_parts["extension"] === "jpg" || 
                    $path_parts["extension"] === "jpeg" || 
                    $path_parts["extension"] === "JPG"
                ) {
                    $image = imagecreatefromjpeg($imagePath);
                }
                
                if ($path_parts["extension"] === "png" || $path_parts["extension"] === "PNG") {
                    $image = imagecreatefrompng($imagePath);
                }

                if (! imageistruecolor($image)) {
                    imagepalettetotruecolor($image);
                }

                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $adjustedWidth, $adjustedHeight, $originalWidth, $originalHeight);
                imagewebp($image_p, $newImagePath, $qualityImage);
                imagedestroy($image);
                imagedestroy($image_p);

                echo "Converted File: " . $newImagePath . PHP_EOL;
            } else {
                $fileName = array_key_exists('extension', $path_parts) 
                    ? $path_parts["filename"] . "." . $path_parts["extension"] 
                    : $path_parts["filename"];

                echo "non-convertible file: " . $fileName . PHP_EOL; 
            }
        } else {
            echo "recursion in folder: $folderFile" . PHP_EOL;
            convertAllImagesFromFoldersToWEBP($folderPath, $extensions, $qualityImage, $newWidth, $newHeight);
        }
    }
}