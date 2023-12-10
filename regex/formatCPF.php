<?php

function formatCPF(string $value): string
{ 
    $cpfLength = 11;
    $cpf = preg_replace("/\D/", '', $value);

    if (strlen($cpf) < $cpfLength) {
        $cpf = str_pad($cpf, $cpfLength, 0, STR_PAD_LEFT);
    } 

    return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cpf);
}