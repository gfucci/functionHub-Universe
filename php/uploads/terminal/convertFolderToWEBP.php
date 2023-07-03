<?php

ini_set('memory_limit', '3000M');
$path = getcwd();

$extensions = [
    'jpg',
    'jpeg',
    'JPG',
    'png',
    'PNG'
];

function convertAllImagesFromFolder($folderPath, $extensions) 
{
    $folder = glob($folderPath . '/*');

    foreach ($folder as $key => $folderFile) 
    {
        if (!is_dir($folderFile)) {
    
            $path_parts = pathinfo($folderFile);
    
            if(array_key_exists('extension', $path_parts) && in_array($path_parts['extension'], $extensions)) {
    
                $imagePath = $path_parts['dirname'] . "/" . $path_parts["basename"];
                $newImageName = str_replace($path_parts['extension'], 'webp', $path_parts["basename"]);
                $newImagePath = $path_parts['dirname'] . "/" . $newImageName;
                $quality = 75;

                if (filesize($folderFile) === 0) {
                    echo "Arquivo corrompido deletado: $folderFile";
                    unlink($folderFile);
                    continue;
                }
                
                if ($path_parts["extension"] === "jpg" || $path_parts["extension"] === "jpeg" || $path_parts["extension"] === "JPG") {
                    $image = imagecreatefromjpeg($imagePath);
                }
                
                if ($path_parts["extension"] === "png") {
                    $image = imagecreatefrompng($imagePath);
                }

                if (!imageistruecolor($image)) {
                    imagepalettetotruecolor($image);
                }

                imagewebp($image, $newImagePath, $quality);
                imagedestroy($image);

                echo "Arquivo convertido: " . $newImagePath . PHP_EOL;
            } else {

                $fileName = array_key_exists('extension', $path_parts) ? 
                    $path_parts["filename"] . "." . $path_parts["extension"] 
                        : 
                    $path_parts["filename"];

                echo "Arquivo não convertível: " . $fileName . PHP_EOL; 
            }
           
        } else {
            echo "recursividade na pasta: $folderFile" . PHP_EOL;
            convertAllImagesFromFolder($folderFile, $extensions);
        }
    }
}

convertAllImagesFromFolder($path, $extensions);

function echo_memory_usage() {

    $mem_usage = memory_get_usage(true);
    if ($mem_usage < 1024) {
        echo $mem_usage." bytes";
    } elseif ($mem_usage < 1048576) {
        echo round($mem_usage/1024,2)." kilobytes";
    } else {
        echo round($mem_usage/1048576,2)." megabytes";
    }
}

echo_memory_usage();
echo PHP_EOL;
$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
$time = $time / 60;
echo "O script executou em $time minutos.";