<?php

class UsuarioDAO {

    private $connection = null;

    public function __construct() {
        $this->connection = ConnectionDB::getInstance();
    }

    public function insereUsuario($usuario) {
        try {

            $SQLInsert = "INSERT INTO tbl_usuarios (nome_us, email_us, login_us, "
                    . "senha_us, perfil_us) VALUES (?,?,?,?,?);";
            $create = $this->connection->prepare($SQLInsert);

            $create->bindValue(1, $usuario->nome_us, PDO::PARAM_STR);
            $create->bindValue(2, $usuario->email_us, PDO::PARAM_STR);
            $create->bindValue(3, $usuario->login_us, PDO::PARAM_STR);
            $create->bindValue(4, md5($usuario->senha_us), PDO::PARAM_STR);
            $create->bindValue(5, $usuario->perfil_us, PDO::PARAM_INT);

            // print_r($create);exit;
            $create->execute();

            //Encerra a conexão
            $this->connection = null;
        } catch (PDOException $exc) {
            echo "Ocorreram erros ao inserir um novo usuario!" . $exc;
        }
    }

    public function listaUsuarios() {
        try {

            $SQLLists = "select * from tbl_usuarios";
            $lists = $this->connection->prepare($SQLLists);

            $lists->execute();
            $usuarios = $lists->fetchAll(PDO::FETCH_CLASS, 'UsuarioDAO');

            $this->connection = null;

            return $usuarios;
        } catch (PDOException $exc) {
            echo 'Ocorreram erros ao pesquisar os usuários!' . $exc;
        }
    }

    public function buscaUsuario($usuario) {
        try {

            $SQLList = "select * from tbl_usuarios where login_us = ? and senha_us = ?";
            $list = $this->connection->prepare($SQLList);

            $list->bindValue(1, $usuario->login_us, PDO::PARAM_STR);
            $list->bindValue(2, md5($usuario->senha_us), PDO::PARAM_STR);
            $list->execute();

            $this->connection = null;

            $dados = $list->fetch();

            $usuario->id_us = $dados['id_us'];
            $usuario->nome_us = $dados['nome_us'];
            $usuario->status_us = $dados['status_us'];

            return $usuario;
        } catch (PDOException $exc) {
            echo 'Ocorreram erros ao pesquisar o usuário!' . $exc;
        }
    }

    public function listaUsuario($id_us) {
        try {

            $SQLList = "select * from tbl_usuarios where id_us = ?";
            $list = $this->connection->prepare($SQLList);

            $list->bindValue(1, $id_us, PDO::PARAM_INT);
            $list->execute();

            $usuario = $list->fetchAll(PDO::FETCH_CLASS);

            $this->connection = null;

            return $usuario;
        } catch (PDOException $exc) {
            echo 'Ocorreram erros ao pesquisar o usuário!' . $exc;
        }
    }

    public function atualizaUsuario($usuario) {

        try {
            if ($usuario->senha_us != null) {
                $SQLEdit = "UPDATE tbl_usuarios SET nome_us = ?, email_us =?, "
                        . "login_us = ?, senha_us = ?, "
                        . "status_us = ?, perfil_us = ? WHERE id_us = ?";

                $status = $this->connection->prepare($SQLEdit);

                $status->bindValue(1, $usuario->nome_us, PDO::PARAM_STR);
                $status->bindValue(2, $usuario->email_us, PDO::PARAM_STR);
                $status->bindValue(3, $usuario->login_us, PDO::PARAM_STR);
                $status->bindValue(4, md5($usuario->senha_us), PDO::PARAM_STR);
                $status->bindValue(5, $usuario->status_us, PDO::PARAM_STR);
                $status->bindValue(6, $usuario->perfil_us, PDO::PARAM_INT);
                $status->bindValue(7, $usuario->id_us, PDO::PARAM_INT);
            } else {
                
                $SQLEdit = "UPDATE tbl_usuarios SET nome_us = ?, email_us = ?, "
                        . "login_us = ?, status_us = ?, "
                        . "perfil_us = ? WHERE id_us = ?";

                $status = $this->connection->prepare($SQLEdit);

                $status->bindValue(1, $usuario->nome_us, PDO::PARAM_STR);
                $status->bindValue(2, $usuario->email_us, PDO::PARAM_STR);
                $status->bindValue(3, $usuario->login_us, PDO::PARAM_STR);
                $status->bindValue(4, $usuario->status_us, PDO::PARAM_STR);
                $status->bindValue(5, $usuario->perfil_us, PDO::PARAM_INT);
                $status->bindValue(6, $usuario->id_us, PDO::PARAM_INT);
            }

            $status->execute();
            $this->connection = null;

            return $usuario;
            
        } catch (PDOException $exc) {
            $erro = $exc->getCode();
            unset($_SESSION["success"]);
            $_SESSION['error'] = "Erro $erro! O Usuário não pode ser atualizado! Entre em contato com a equipe de suporte!";
        }
    }

    public function deletaUsuario($usuario) {
        try {

            $SQLDelete = "delete from tbl_usuarios where id_us = ?";
            $delete = $this->connection->prepare($SQLDelete);

            $delete->bindValue(1, $usuario->id_us, PDO::PARAM_INT);
            $delete->execute();

            $this->connection = null;
        } catch (PDOException $exc) {

            if ($exc->getCode() == 23000) {
                unset($_SESSION["success"]);
                $_SESSION['error'] = "O usuário não pode ser deletado, há dados vinculados a ele!";
            }
        }
    }

}
