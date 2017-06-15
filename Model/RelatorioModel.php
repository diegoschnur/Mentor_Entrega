<?php

class RelatorioModel {

    private $id_rl;
    private $id_solicitacao_rl;
    private $obsRelator_rl;
    private $obsDesenvolvedor_rl;
    private $statusRelator_rl;
    private $statusDesenvolvedor_rl;
    private $id_usuario_rl;

    public function __construct() {
        
    }

    public function __set($propriedade, $valor) {
        $this->$propriedade = $valor;
    }

    public function __get($propriedade) {
        return $this->$propriedade;
    }

}