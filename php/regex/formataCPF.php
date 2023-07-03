<?php

function formata_CPF($value)
{
    $CPF_LENGTH = 11;
    $cpf = preg_replace("/\D/", '', $value);

    if (strlen($cpf) < $CPF_LENGTH) {
        $cpf = str_pad($cpf, $CPF_LENGTH, 0, STR_PAD_LEFT);
    } 

    return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cpf);
}