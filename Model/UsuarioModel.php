<?php

class UsuarioModel {

    private $id_us;
    private $nome_us;
    private $login_us;
    private $senha_us;
    private $email_us;
    private $telefone_us;
    private $status_us;
    private $perfil_us;

    public function __construct() {
        
    }

    public function __set($propriedade, $valor) {
        $this->$propriedade = $valor;
    }

    public function __get($propriedade) {
        return $this->$propriedade;
    }

}