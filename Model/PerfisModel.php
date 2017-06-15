<?php

class PerfilModel {

    private $id_pf;
    private $nome_pf;
    private $permissao_relator_us;
    private $permissao_Grelator_us;
    private $permissao_desenvolvedor_us;
    private $permissao_Gdesenvolvedor_us;
    private $permissao_secretario_us;
    private $permissao_visualizador_us;

    public function __construct() {
        
    }

    public function __set($propriedade, $valor) {
        $this->$propriedade = $valor;
    }

    public function __get($propriedade) {
        return $this->$propriedade;
    }

}