<?php

class ProjetoDAO {

    private $connection = null;

    public function __construct() {
        $this->connection = ConnectionDB::getInstance();
    }

    public function insereProjeto($projeto) {
        try {
            $SQLInsert = "INSERT INTO tbl_projetos (nome_prj,descricao_prj,status_prj,id_usuario_prj)VALUES (?,?,?,?);";
            $create = $this->connection->prepare($SQLInsert);

            $create->bindValue(1, $projeto->nome_prj, PDO::PARAM_STR);
            $create->bindValue(2, $projeto->descricao_prj, PDO::PARAM_STR);
            $create->bindValue(3, $projeto->status_prj, PDO::PARAM_STR);
            $create->bindValue(4, $projeto->id_usuario_prj, PDO::PARAM_INT);

            $create->execute();

            //Encerra a conexão
            $this->connection = null;
        } catch (PDOException $exc) {
            $erro = $exc->getCode();
            unset($_SESSION["success"]);
            $_SESSION["error"] = "Erro $erro! O projeto não pode ser cadastrado! Entre em contato com a equipe de suporte!";
        }
    }

    public function listaProjetos() {
        try {

            $SQLLists = "SELECT * from tbl_projetos";
            $list = $this->connection->prepare($SQLLists);

            $list->execute();

            if ($list->rowCount() > 0) {
                $projetos = $list->fetchAll(PDO::FETCH_CLASS, 'ProjetoDAO');
                //print_r($projetos);exit;
                $this->connection = null;

                return $projetos;
            }

            return [];
        } catch (PDOException $exc) {
            $erro = $exc->getCode();
            unset($_SESSION["success"]);
            $_SESSION["error"] = "Erro $erro! Os projetos não puderam ser listados! Entre em contato com a equipe de suporte!";
        }
    }

    public function listaProjeto($id_prj) {
        try {

            $SQLList = "select * from tbl_projetos where id_prj = ?";
            $status = $this->connection->prepare($SQLList);

            $status->bindValue(1, $id_prj, PDO::PARAM_INT);
            $status->execute();

            $projeto = $status->fetchAll(PDO::FETCH_CLASS);

            $this->connection = null;
            return $projeto;
        } catch (PDOException $exc) {
            $erro = $exc->getCode();
            unset($_SESSION["success"]);
            $_SESSION["error"] = "Erro $erro! O projeto não pode ser listado! Entre em contato com a equipe de suporte!";
        }
    }

    public function atualizaProjeto($projeto) {

        try {

            $SQLEdit = "UPDATE tbl_projetos SET nome_prj = ?, descricao_prj =?, "
                    . "status_prj = ? WHERE id_prj = ?";
            $status = $this->connection->prepare($SQLEdit);

            $status->bindValue(1, $projeto->nome_prj, PDO::PARAM_STR);
            $status->bindValue(2, $projeto->descricao_prj, PDO::PARAM_STR);
            $status->bindValue(3, $projeto->status_prj, PDO::PARAM_STR);
            $status->bindValue(4, $projeto->id_prj, PDO::PARAM_INT);

            $status->execute();
            $this->connection = null;

            return $projeto;
            
        } catch (PDOException $exc) {
            $erro = $exc->getCode();
            unset($_SESSION["success"]);
            $_SESSION["error"] = "Erro $erro! O projeto não pode ser atualizado! Entre em contato com a equipe de suporte!";
        }
    }

    public function deletaProjeto($projeto) {

        try {

            $SQLDelete = "delete from tbl_projetos where id_prj = ?";
            $status = $this->connection->prepare($SQLDelete);

            $status->bindValue(1, $projeto->id_prj, PDO::PARAM_INT);
            $status->execute();

            $this->connection = null;
        } catch (PDOException $exc) {
            if ($exc->getCode() == 23000) {
                unset($_SESSION["success"]);
                $_SESSION["error"] = "O projeto não pode ser deletado, há uma ou mais solicitações vinculadas a ele!";
            }
        }
    }

}
