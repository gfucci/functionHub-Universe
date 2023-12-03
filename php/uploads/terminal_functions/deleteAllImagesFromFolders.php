<?php

//EXTENSIONS EXAMPLE
$extensions = [
    'jpg',
    'jpeg',
    'JPG',
    'png',
    'PNG'
];

function deleteAllImagesFromFolders(string $folderPath, array $extensions): void
{
    ini_set('memory_limit', '-1');

    $folder = glob($folderPath . '/*');
    
    foreach ($folder as $key => $folderFile) {
        if (!is_dir($folderFile)) {
            $path_parts = pathinfo($folderFile);
    
            if(
                array_key_exists('extension', $path_parts) && 
                in_array($path_parts['extension'], $extensions)
            ) {
                echo "file: $folderFile" . PHP_EOL;
                unlink($folderFile);
            }
        } else {
            deleteAllImagesFromFolders($folderFile, $extensions);
        }
    }
}