<?php

//function setaStatusDeAtraso($dataAtual, $dataNeces) {
//    
//    if($dataAtual > $dataNecessidade){
//        return "AT";
//    } elseif ($dataAtual - $dataNecessidade <=5 || $dataAtual - $dataNecessidade >=0) {
//        return "US";
//    } else {
//        return "PZ";
//    }
//    
//    formataUmaCasaDecimal(calculaPorcentagem($av->tempoTeste_sol, somaTempo($av->id_sol)))
// }


function pegaDataDoMomento(){
    return $today = date("Y-m-d");
}

function formataData($data) {

    return date("d/m/Y", strtotime($data));
}

function formataUmaCasaDecimal($numero){
    
    $formatado = number_format($numero, 1);
    
    return $formatado . "%";
}

function somaTempo($solicitacao) {

    $fichasTecnicasDAO = new FichaTecnicaDAO();
    $fichasTecnicas = $fichasTecnicasDAO->listaFichasTecnicas($solicitacao);

    $tempoTotal = 0;
    foreach ($fichasTecnicas as $ft) :
        $tempoTotal += $ft->tempoTeste_ft;
    endforeach;

    return $tempoTotal;
}

function calculaPorcentagem($tempoSOL, $tempoFT) {
    
    $porcentagem = ($tempoFT / $tempoSOL) * 100;
    if ( $porcentagem > 100) {
        return 100 . "%";
    }

    return $porcentagem;
}
