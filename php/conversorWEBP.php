<?php
/**
    * BLOCO DE CÓDIGO PARA TRATAMENTO DO UPLOAD - ADICIONAR APÓS O UPLOAD DA IMAGEM ORIGINAL NO SERVIDOR (REDUZ EM ATÉ 98% DO TAMANHO DO ARQUIVO SEM PERDER A QUALIDADE)
    * PEGA AS INFORMAÇÕES DO CAMINHO E NOME DA IMAGEM E DEFINE A QUALIDADE DO TRATAMENTO
    * DEFINE A LARGURA E A ALTURA DESEJADA, PEGANDO TAMBÉM SEU RATIO ORIGINAL E O RATIO DESEJADO. ISSO É FEITO PARA O PHP REDIMENSIONAR A IMAGEM COMPARANDO OS RATIOS, NÃO DEFORMANDO A IMAGEM
    * CRIA DUAS IMAGENS, UMA REDIMENSIONADA E OUTRA JPG/JPEG OU PNG
    * REDIMENSIONA A IMAGEM FAZENDO O CRUZAMENTO ENTRE A IMAGEM JPG/JPEG/PNG COM A IMAGEM REDIMENSIONADA
    * CONVERTE A IMAGEM CRUZADA PARA WEBP E SALVA NO SERVIDOR
    * DESTROI AS IMAGENS CRIADAS E DELETA O UPLOAD ORIGINAL DA FOTO NO SERVIDOR, FICANDO APENAS O UPLOAD WEBP
*/
$path_parts = pathinfo($_FILES["imagem"]['name']);
$imagePath = $config['upload_path'] . "/" . $_FILES["imagem"]['name'];
$newImageName = str_replace($path_parts['extension'], 'webp', $_FILES["imagem"]["name"]);
$newImagePath = $config['upload_path'] . "/" . $newImageName;

/**
 * DEFINA AQUI A QUALIDADE, ENTRE DE 25 A 100. MENOS QUE 25 PERDE MUITO A QUALIDADE
 * SE FOR SETADO 100, A QUALIDADE SE MANTÉM. PORÉM TOMAR CUIDADO, SE A IMAGEM FOR DE UMA RESOLUÇÃO QUE JÁ E MUITO BAIXA, VAI AUMENTAR A RESOLUÇÃO E AUMENTAR O TAMANHO DO ARQUIVO, PERDENDO O OBJETIVO DO SCRIPT. USAR 100 PARA QUEM USA IMAGENS COM ÓTIMA QUALIDADE
 * PARA OS DEMAIS O IDEAL É DE 50 A 75.
 * QUANTO MENOR A QUALIDADE, MENOR O TAMANHO DO ARQUIVO, PORÉM MAIS PIXELADA SERÁ A IMAGEM.
*/
$quality = 100;

list($originalWidth, $originalHeight) = getimagesize($imagePath);
$newWidth = 1095; // DEFINA A NOVA LARGURA DA FOTO (USAR A WIDTH QUE FOI SETADA NO CSS)
$newHeight = 600; // DEFINA A NOVA ALTURA DA FOTO (USAR A HEIGTH QUE FOI SETADA NO CSS)

$originalRatio = $originalWidth / $originalHeight;
$desiredRatio = $newWidth / $newHeight;

if ($originalRatio > $desiredRatio) {

    $adjustedWidth = $newWidth;
    $adjustedHeight = $newWidth / $originalRatio;
} else {

    $adjustedWidth = $newHeight * $originalRatio;
    $adjustedHeight = $newHeight;
}

$image_p = imagecreatetruecolor($adjustedWidth, $adjustedHeight);

if ($_FILES["imagem"]["type"] === "image/jpeg") {

    $image = imagecreatefromjpeg($imagePath);

} else if ($_FILES["imagem"]["type"] === "image/png") {

    $image = imagecreatefrompng($imagePath);
}

imagecopyresampled($image_p, $image, 0, 0, 0, 0, $adjustedWidth, $adjustedHeight, $originalWidth, $originalHeight);
imagewebp($image_p, $newImagePath, $quality);
imagedestroy($image);
imagedestroy($image_p);
unlink($imagePath);

$data["column_database"] = $newImagePath; // COLOCAR AQUI O CAMINHO PARA SALVAR NO BANCO COM O NOVO NOME DA IMAGEM