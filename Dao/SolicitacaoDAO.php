<?php

class SolicitacaoDAO {

    private $connection = null;

    public function __construct() {
        $this->connection = ConnectionDB::getInstance();
    }

    public function insereSolicitacao($solicitacao) {
        
        try {
            $SQLInsert = "INSERT INTO tbl_solicitacoes (nome_sol,dataAbertura_sol,"
                    . "dataNecessidade_sol,tempoTeste_sol,unidadeMedida_sol,"
                    . "componentesTestar_sol,metodologia_sol,observacoes_sol,"
                    . "visibilidade_sol,idProjeto_sol,idUsuario_sol) "
                    . "VALUES (?,?,?,?,?,?,?,?,?,?,?);";
            $status = $this->connection->prepare($SQLInsert);

            $status->bindValue(1, $solicitacao->nome_sol);
            $status->bindValue(2, $solicitacao->dataAbertura_sol);
            $status->bindValue(3, $solicitacao->dataNecessidade_sol);
            $status->bindValue(4, $solicitacao->tempoTeste_sol);
            $status->bindValue(5, $solicitacao->unidadeMedida_sol);
            $status->bindValue(6, $solicitacao->componentesTestar_sol);
            $status->bindValue(7, $solicitacao->metodologia_sol);
            $status->bindValue(8, $solicitacao->observacoes_sol);
            $status->bindValue(9, $solicitacao->visibilidade_sol);
            $status->bindValue(10, $solicitacao->idProjeto_sol);
            $status->bindValue(11, $solicitacao->idUsuario_sol);

            $status->execute();
            $this->connection = null;
            
        } catch (PDOException $exc) {
            $erro = $exc;
            unset($_SESSION["success"]);
            $_SESSION['error'] = "Erro $erro! A solicitação não pode ser criada! Entre em contato com a equipe de suporte!";
        }
    }

    public function listaSolicitacoes() {
        try {
            $SQLLists = "select * from tbl_solicitacoes";
            $status = $this->connection->prepare($SQLLists);

            $status->execute();
            $solicitacoes = $status->fetchAll(PDO::FETCH_CLASS, 'SolicitacaoDAO');

            $this->connection = null;

            return $solicitacoes;
        } catch (PDOException $exc) {
            $erro = $exc->getCode();
            unset($_SESSION["success"]);
            $_SESSION['error'] = "Erro $erro! Não foi possível listar as solicitações! Entre em contato com a equipe de suporte!";
        }
    }

    public function listaSolicitacao($id_sol) {
        try {
            $SQLList = "select * from tbl_solicitacoes where id_sol = ?";
            $status = $this->connection->prepare($SQLList);

            $status->bindValue(1, $id_sol, PDO::PARAM_INT);
            $status->execute();

            $solicitacao = $status->fetchAll(PDO::FETCH_CLASS);

            $this->connection = null;

            return $solicitacao;
        } catch (PDOException $exc) {
           $erro = $exc->getCode();
            unset($_SESSION["success"]);
            $_SESSION['error'] = "Erro $erro! A solicitação não pode ser listada! Entre em contato com a equipe de suporte!";
        }
    }
    
    public function listaSolicitacoesDoUsuario($id_us_logado) {
        try {
            $SQLList = "select * from tbl_solicitacoes where idUsuario_sol = ?";
            $status = $this->connection->prepare($SQLList);

            $status->bindValue(1, $id_us_logado, PDO::PARAM_INT);
            $status->execute();

            $solicitacoesDoUsuario = $status->fetchAll(PDO::FETCH_CLASS);

            $this->connection = null;

            return $solicitacoesDoUsuario;
            
        } catch (PDOException $exc) {
           $erro = $exc->getCode();
            unset($_SESSION["success"]);
            $_SESSION['error'] = "Erro $erro! A solicitação não pode ser listada! Entre em contato com a equipe de suporte!";
        }
    }

    public function atualizaSolicitacao($solicitacao) {

        try {

            $SQLEdit = "UPDATE tbl_solicitacoes SET nome_sol = ?, dataNecessidade_sol =?, "
                    . "tempoTeste_sol = ?, unidadeMedida_sol = ?, componentesTestar_sol = ?, "
                    . "metodologia_sol = ?, observacoes_sol = ?, visibilidade_sol = ?, "
                    . "status_sol = ?, idProjeto_sol = ? WHERE id_sol = ?";
            $status = $this->connection->prepare($SQLEdit);

            $status->bindValue(1, $solicitacao->nome_sol, PDO::PARAM_STR);
            $status->bindValue(2, $solicitacao->dataNecessidade_sol);
            $status->bindValue(3, $solicitacao->tempoTeste_sol, PDO::PARAM_INT);
            $status->bindValue(4, $solicitacao->unidadeMedida_sol, PDO::PARAM_STR);
            $status->bindValue(5, $solicitacao->componentesTestar_sol, PDO::PARAM_STR);
            $status->bindValue(6, $solicitacao->metodologia_sol, PDO::PARAM_STR);
            $status->bindValue(7, $solicitacao->observacoes_sol, PDO::PARAM_STR);
            $status->bindValue(8, $solicitacao->visibilidade_sol, PDO::PARAM_STR);
            $status->bindValue(9, $solicitacao->status_sol, PDO::PARAM_STR);
            $status->bindValue(10, $solicitacao->idProjeto_sol, PDO::PARAM_INT);
            $status->bindValue(11, $solicitacao->id_sol, PDO::PARAM_INT);

            $status->execute();

            $this->connection = null;
            return $solicitacao;
            
        } catch (PDOException $exc) {
            $erro = $exc->getCode();
            unset($_SESSION["success"]);
            $_SESSION['error'] = "Erro $erro! A solicitação não pode ser atualizada! Entre em contato com a equipe de suporte!";
        }
    }

    public function deletaSolicitacao($solicitacao) {

        try {

            $SQLDelete = "delete from tbl_solicitacoes where id_sol = ?";
            $status = $this->connection->prepare($SQLDelete);

            $status->bindValue(1, $solicitacao->id_sol, PDO::PARAM_INT);
            $status->execute();

            $this->connection = null;
        } catch (PDOException $exc) {
            if ($exc->getCode() == 23000) {
                unset($_SESSION["success"]);
                $_SESSION['error'] = "A solicitação não pode ser deletada, há uma ou mais fichas técnicas vinculadas a ela!";
            }
        }
    }

}
