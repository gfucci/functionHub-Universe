function jsDateFormatToCommonFormat(javaScriptDate) 
{
    /**
     * javaScriptDate => "yyyy-mm-dd hh:mm:ss"
     * return "yyyy-mm-dd hh:mm:ss" to "dd/mm/yyyy"
    */
    var entrada = Date.parse(javaScriptDate);

    var data = new Date(entrada),
        day  = data.getDate().toString(),
        dayWithZero = (day.length == 1) ? '0' + day : day,
        month  = (data.getMonth()+1).toString(),
        monthWithZero = (month.length == 1) ? '0' + month : month,
        yearWithZero = data.getFullYear()
    ;

    return dayWithZero + "/" +monthWithZero + "/" + yearWithZero;
}