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

$count = 0;

function deleteUnusedImagesFromFolder($folderPath, $extensions, $count) 
{
    global $count;
    $folder = glob($folderPath . '/*');
    
    foreach ($folder as $key => $folderFile) 
    {
        if (!is_dir($folderFile)) {
    
            $path_parts = pathinfo($folderFile);
    
            if(array_key_exists('extension', $path_parts) && in_array($path_parts['extension'], $extensions)) {
    
                $count++;
                echo "arquivo: $folderFile" . PHP_EOL;
                unlink($folderFile);
            }

        } else {
            deleteUnusedImagesFromFolder($folderFile, $extensions, $count);
        }
    }
}

deleteUnusedImagesFromFolder($path, $extensions, $count);

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
echo PHP_EOL;
echo "Arquivos deletados: $count" . PHP_EOL;