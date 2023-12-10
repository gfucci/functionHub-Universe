<?php

function convertUploadedFileToWEBP(
    string $upload_path, 
    int $qualityImage, 
    int $newWidth, 
    int $newHeight
): void
{ 
    $path_parts = pathinfo($_FILES["imagem"]['name']);
    $imagePath = $upload_path . "/" . $_FILES["imagem"]['name'];
    $newImageName = str_replace($path_parts['extension'], 'webp', $_FILES["imagem"]["name"]);
    $newImagePath = $upload_path . "/" . $newImageName;
    
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
    
    $newImage = imagecreatetruecolor($adjustedWidth, $adjustedHeight);
    
    if ($_FILES["imagem"]["type"] === "image/jpeg") {
        $oldImage = imagecreatefromjpeg($imagePath);
    } elseif ($_FILES["imagem"]["type"] === "image/png") {
        $oldImage = imagecreatefrompng($imagePath);
    }

    if (! imageistruecolor($oldImage)) {
        imagepalettetotruecolor($oldImage);
    }
    
    imagecopyresampled($newImage, $oldImage, 0, 0, 0, 0, $adjustedWidth, $adjustedHeight, $originalWidth, $originalHeight);
    imagewebp($newImage, $newImagePath, $qualityImage);
    imagedestroy($oldImage);
    imagedestroy($newImage);
    unlink($imagePath);
}