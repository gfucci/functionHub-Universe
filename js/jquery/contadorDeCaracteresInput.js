/**
 * ESSE SCRIPT CONTA A QUANTIDADE DE CARACTERES QUE ESTÁ SENDO DIGITADA EM UM INPUT, DEPOIS RENDERIZA UM BLOCO HTML AVISANDO QUE O PASSOU O LIMITE 
 * NUMERO DE CARACTERES BASEADO NA QUANTIDADE IDEAL PARA O SERP DO GOOGLE
 * ADICIONAR BLOCOS HTML DO JQUERY CORRESPONDENTE AO PROJETO QUE ESTÁ SENDO USADO
*/
$(document).ready(function() {

    function atualizaContagem(elemento, contador, limiteCaracteres, aviso)
    {
        var caracteresDigitados = $(elemento).val().length;
        $(contador).html(caracteresDigitados);

        caracteresDigitados > limiteCaracteres ? $(aviso).css({display: "block"}) : $(aviso).css({display: "none"});
    }

    //Carregamento da página
    atualizaContagem("#titulo", "#contador-titulo", 60, "#aviso-caractere-titulo");
    atualizaContagem("#meta_descricao", "#contador-meta_descricao", 160, "#aviso-caractere-meta_descricao");

    //titulo - Digitação do input
    $("#titulo").keyup(function() {
        atualizaContagem("#titulo", "#contador-titulo", 60, "#aviso-caractere-titulo")
    });

    //meta-descrição - Digitação do input
    $("#meta_descricao").keyup(function() {
        atualizaContagem("#meta_descricao", "#contador-meta_descricao", 160, "#aviso-caractere-meta_descricao")
    });
}) 