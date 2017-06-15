<?php

class RelatorioDAO {

    private $connection = null;

    public function __construct() {
        $this->connection = ConnectionDB::getInstance();
    }

    public function insereRelatorio($relatorio) {

        try {
            $SQLInsert = "INSERT INTO tbl_relatorios (id_solicitacao_rl, obsRelator_rl, "
                    . "statusRelator_rl, id_usuario_rel) VALUES(?,?,?,?);";
            $create = $this->connection->prepare($SQLInsert);

            $create->bindValue(1, $relatorio->id_solicitacao_rl, PDO::PARAM_INT);
            $create->bindValue(2, $relatorio->obsRelator_rl, PDO::PARAM_STR);
            $create->bindValue(3, $relatorio->statusRelator_rl, PDO::PARAM_STR);
            $create->bindValue(4, $relatorio->id_usuario_rel, PDO::PARAM_INT);

            $create->execute();

            //Encerra a conexão
            $this->connection = null;
        } catch (PDOException $exc) {
            echo "Ocorreram erros ao inserir a mensagem no relatório final!" . $exc->getMessage();
        }
    }

    public function listaRelatorio($id_solicitacao_rl) {
        try {

            $SQLList = "SELECT * from tbl_relatorios WHERE id_solicitacao_rl = ?";
            $status = $this->connection->prepare($SQLList);

            $status->bindValue(1, $id_solicitacao_rl, PDO::PARAM_INT);
            $status->execute();

            $relatorio = $status->fetchAll(PDO::FETCH_CLASS);

            $this->connection = null;
            return $relatorio;
        } catch (PDOException $exc) {
            echo 'Ocorreram erros ao pesquisar o relatório!' . $exc;
        }
    }

    public function atualizaProjeto($relatorio) {
        try {

            $SQLEdit = "UPDATE tbl_relatorios set obsDesenvolvedor_rl = ?, "
                    . "statusDesenvolvedor_rl = ?, id_usuario_sol = ?, dataEncerramento_rl = ?"
                    . "where id_solicitacao_rl = ?";
            $status = $this->connection->prepare($SQLEdit);

            $status->bindValue(1, $relatorio->obsDesenvolvedor_rl, PDO::PARAM_STR);
            $status->bindValue(2, $relatorio->statusDesenvolvedor_rl, PDO::PARAM_STR);
            $status->bindValue(3, $relatorio->id_usuario_sol, PDO::PARAM_INT);
            $status->bindValue(4, $relatorio->dataEncerramento_rl, PDO::PARAM_STR);
            $status->bindValue(5, $relatorio->id_solicitacao_rl, PDO::PARAM_INT);

            $status->execute();
            $this->connection = null;
            
            return $relatorio;
            
        } catch (PDOException $exc) {
            echo 'Ocorreram erros ao pesquisar os projetos!' . $exc;
        }
    }

    public function deletaProjeto($id_prj) {
        try {

            $SQLDelete = "delete from tbl_projetos where id_prj = ?";
            $status = $this->connection->prepare($SQLDelete);

            $status->bindValue(1, $id_prj);
            $status->execute();

            $this->connection = null;
        } catch (PDOException $exc) {
            echo "Ocorreram erros ao deletar o projeto! <br>$exc";
        }
    }

}
