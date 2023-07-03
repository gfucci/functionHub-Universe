function dataSorteioFormatada(dataDoTimestamp) {
    /**
     * dataDoTimeStamp => "yyyy-mm-dd hh:mm:ss"
     * retorna "yyyy-mm-dd hh:mm:ss" para "dd/mm/yyyy"
    */

    var entrada = Date.parse(dataDoTimestamp);

    var data = new Date(entrada),
        dia  = data.getDate().toString(),
        diaComZero = (dia.length == 1) ? '0' + dia : dia,
        mes  = (data.getMonth()+1).toString(), //+1 pois no getMonth Janeiro começa com zero.
        mesComZero = (mes.length == 1) ? '0' + mes : mes,
        anoComZero = data.getFullYear()
    ;

    return diaComZero + "/" +mesComZero + "/" + anoComZero;
}