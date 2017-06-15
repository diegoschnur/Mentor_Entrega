function validarSenha(senha1, senha2, campo) {
    var resultado = document.getElementById(campo);
    
    senhaPrimaria = document.getElementById(senha1).value;
    senhaSecundaria = document.getElementById(senha2).value;
    
    if (senhaPrimaria == senhaSecundaria) {
        resultado.innerHTML = "Cadastrar Novo Usuário";
    } else {
        resultado.innerHTML = "Senhas Incompatíveis";
    }
}

$(document).ready( function () {
    var table = $('#example').dataTable();
    var tableTools = new $.fn.dataTable.TableTools( table, {
        "buttons": [
            "copy",
            "csv",
            "xls",
            "pdf",
            { "type": "print", "buttonText": "Print me!" }
        ]
    } );
      
    $( tableTools.fnContainer() ).insertAfter('div.info');
} );