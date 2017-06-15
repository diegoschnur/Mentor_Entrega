<?php

class PerfisDAO {

    private $connection = null;

    public function __construct() {
        $this->connection = ConnectionDB::getInstance();
    }

    public function inserePerfil($perfil) {
        try {

            $SQLInsert = "INSERT INTO tbl_perfis (nome_pf, permissao_relator_us, permissao_Grelator_us, permissao_desenvolvedor_us,"
                    . "permissao_Gdesenvolvedor_us, permissao_secretario_us, permissao_visualizador_us) VALUES (?,?,?,?,?,?,?);";
            $create = $this->connection->prepare($SQLInsert);

            $create->bindValue(1, $perfil->nome_pf, PDO::PARAM_STR);
            $create->bindValue(2, $perfil->permissao_relator_us, PDO::PARAM_STR);
            $create->bindValue(3, $perfil->permissao_Grelator_us, PDO::PARAM_STR);
            $create->bindValue(4, $perfil->permissao_desenvolvedor_us, PDO::PARAM_STR);
            $create->bindValue(5, $perfil->permissao_Gdesenvolvedor_us, PDO::PARAM_STR);
            $create->bindValue(6, $perfil->permissao_secretario_us, PDO::PARAM_STR);
            $create->bindValue(7, $perfil->permissao_visualizador_us, PDO::PARAM_INT);

            // print_r($create);exit;
            $create->execute();

            //Encerra a conexão
            $this->connection = null;
        } catch (PDOException $exc) {
            echo "Ocorreram erros ao inserir um novo perfil!" . $exc;
        }
    }

    public function listaPerfis() {
        try {

            $SQLLists = "select * from tbl_perfis";
            $lists = $this->connection->prepare($SQLLists);
            $lists->execute();
            
            $perfis = $lists->fetchAll(PDO::FETCH_CLASS, 'PerfisDAO');

            $this->connection = null;

            return $perfis;
        } catch (PDOException $exc) {
            echo 'Ocorreram erros ao pesquisar os perfis!' . $exc;
        }
    }

    public function buscaPerfil($perfil) {
        try {

            $SQLList = "select * from tbl_perfis where id_pf = ?";
            $list = $this->connection->prepare($SQLList);

            $list->bindValue(1, $perfil->id_pf, PDO::PARAM_STR);
            $list->execute();

            $this->connection = null;

            $dados = $list->fetch();

            $perfil->id_pf = $dados['id_pf'];
            $perfil->nome_pf = $dados['nome_pf'];

            return $perfil;
        } catch (PDOException $exc) {
            echo 'Ocorreram erros ao pesquisar o usuário!' . $exc;
        }
    }

    public function listaPerfil($id_pf) {

        try {

            $SQLList = "select * from tbl_perfis where id_pf = ?";
            $list = $this->connection->prepare($SQLList);

            $list->bindValue(1, $id_pf, PDO::PARAM_INT);
            $list->execute();

            $perfil = $list->fetchAll(PDO::FETCH_CLASS);
            $this->connection = null;

            return $perfil;
            
        } catch (PDOException $exc) {
            echo 'Ocorreram erros ao pesquisar o usuário!' . $exc;
        }
    }

    public function atualizaPerfil($perfil) {
        try {

            $SQLEdit = "UPDATE tbl_perfis SET nome_pf = ?, permissao_relator_us =?, "
                    . "permissao_Grelator_us = ?, permissao_desenvolvedor_us = ?, "
                    . "permissao_Gdesenvolvedor_us = ?, permissao_secretario_us = ?, "
                    . "permissao_visualizador_us = ? WHERE id_pf = ?";
            $status = $this->connection->prepare($SQLEdit);

            $status->bindValue(1, $perfil->nome_pf, PDO::PARAM_STR);
            $status->bindValue(2, $perfil->permissao_relator_us, PDO::PARAM_STR);
            $status->bindValue(3, $perfil->permissao_Grelator_us, PDO::PARAM_STR);
            $status->bindValue(4, $perfil->permissao_desenvolvedor_us, PDO::PARAM_STR);
            $status->bindValue(5, $perfil->permissao_Gdesenvolvedor_us, PDO::PARAM_STR);
            $status->bindValue(6, $perfil->permissao_secretario_us, PDO::PARAM_STR);
            $status->bindValue(7, $perfil->permissao_visualizador_us, PDO::PARAM_INT);
            $status->bindValue(8, $perfil->id_pf, PDO::PARAM_INT);

            $status->execute();

            $this->connection = null;

            return $perfil;
        } catch (PDOException $exc) {
            $erro = $exc->getCode();
            unset($_SESSION["success"]);
            $_SESSION['error'] = "Erro $erro! O Perfil não pode ser atualizado! Entre em contato com a equipe de suporte!";
        }
    }

    public function deletaPerfil($perfil) {
        try {

            $SQLDelete = "delete from tbl_perfis where id_pf = ?";
            $delete = $this->connection->prepare($SQLDelete);

            $delete->bindValue(1, $perfil->id_pf, PDO::PARAM_INT);
            $delete->execute();

            $this->connection = null;
        } catch (PDOException $exc) {

            if ($exc->getCode() == 23000) {
                unset($_SESSION["success"]);
                $_SESSION['error'] = "O perfil não pode ser deletado, há dados vinculados a ele!";
            }
        }
    }

}
