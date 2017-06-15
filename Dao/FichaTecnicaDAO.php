<?php

class FichaTecnicaDAO {

    private $connection = null;

    public function __construct() {
        $this->connection = ConnectionDB::getInstance();
    }

    public function insereFichaTecnica($fichaTecnica) {
        try {

            $SQLInsert = "INSERT INTO tbl_fichastecnicas (nome_ft,dataInicial_ft,dataFinal_ft ,"
                    . "tempoTeste_ft,localTeste_ft,cliente_ft,acompanhamento_ft,componentes_ft ,"
                    . "metodologia_ft,comportamento_ft,observacoes_ft,visibilidade_ft,destaque_ft ,"
                    . "id_solicitacao_ft,id_usuario_ft) "
                    . "VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
            $create = $this->connection->prepare($SQLInsert);

            $create->bindValue(1, $fichaTecnica->nome_ft);
            $create->bindValue(2, $fichaTecnica->dataInicial_ft);
            $create->bindValue(3, $fichaTecnica->dataFinal_ft);
            $create->bindValue(4, $fichaTecnica->tempoTeste_ft);
            $create->bindValue(5, $fichaTecnica->localTeste_ft);
            $create->bindValue(6, $fichaTecnica->cliente_ft);
            $create->bindValue(7, $fichaTecnica->acompanhamento_ft);
            $create->bindValue(8, $fichaTecnica->componentes_ft);
            $create->bindValue(9, $fichaTecnica->metodologia_ft);
            $create->bindValue(10, $fichaTecnica->comportamento_ft);
            $create->bindValue(11, $fichaTecnica->observacoes_ft);
            $create->bindValue(12, $fichaTecnica->visibilidade_ft);
            $create->bindValue(13, $fichaTecnica->destaque_ft);
            $create->bindValue(14, $fichaTecnica->id_solicitacao_ft);
            $create->bindValue(15, $fichaTecnica->id_usuario_ft);

            $create->execute();

            //Encerra a conexão
            $this->connection = null;
        } catch (PDOException $exc) {
            $erro = $exc->getCode();
            unset($_SESSION["success"]);
            $_SESSION['error'] = "Erro $erro! A Ficha Técnica não pode ser criada! Entre em contato com a equipe de suporte!";
        }
    }

    public function listaFichasTecnicas($id_sol) {
        try {
            $SQLListaFts = "select * from tbl_fichastecnicas where id_solicitacao_ft = ? ";
            $lists = $this->connection->prepare($SQLListaFts);
            $lists->bindValue(1, $id_sol);
            $lists->execute();
            $fichasTecnicas = $lists->fetchAll(PDO::FETCH_CLASS, 'FichaTecnicaDAO');

            $this->connection = null;

            return $fichasTecnicas;
        } catch (PDOException $exc) {
            $erro = $exc->getCode();
            unset($_SESSION["success"]);
            $_SESSION['error'] = "Erro $erro! Não foi possível listar as Fichas Técnicas! Entre em contato com a equipe de suporte!";
        }
    }

    public function listaFichaTecnica($id_ft) {
        try {

            $SQLListaFt = "select * from tbl_fichastecnicas where id_ft = ?";
            $list = $this->connection->prepare($SQLListaFt);

            $list->bindValue(1, $id_ft, PDO::PARAM_INT);
            $list->execute();

            $fichaTecnica = $list->fetchAll(PDO::FETCH_CLASS);

            $this->connection = null;
            return $fichaTecnica;
        } catch (PDOException $exc) {
            $erro = $exc->getCode();
            unset($_SESSION["success"]);
            $_SESSION['error'] = "Erro $erro! A Ficha Técnica não pode ser listada! Entre em contato com a equipe de suporte!";
        }
    }

    public function atualizaFichaTecnica($fichaTecnica) {

        try {

            $SQLEdit = "UPDATE tbl_fichastecnicas SET nome_ft = ?, "
                    . "dataFinal_ft = ?, tempoTeste_ft = ?, localTeste_ft = ?, cliente_ft = ?, "
                    . "acompanhamento_ft = ?, componentes_ft = ?, metodologia_ft = ?, "
                    . "comportamento_ft = ?, observacoes_ft = ?, visibilidade_ft = ?, "
                    . "destaque_ft = ?, status_ft = ? WHERE id_ft = ?";
            $status = $this->connection->prepare($SQLEdit);

            $status->bindValue(1, $fichaTecnica->nome_ft, PDO::PARAM_STR);
            $status->bindValue(2, $fichaTecnica->dataFinal_ft);
            $status->bindValue(3, $fichaTecnica->tempoTeste_ft, PDO::PARAM_INT);
            $status->bindValue(4, $fichaTecnica->localTeste_ft, PDO::PARAM_STR);
            $status->bindValue(5, $fichaTecnica->cliente_ft, PDO::PARAM_STR);
            $status->bindValue(6, $fichaTecnica->acompanhamento_ft, PDO::PARAM_STR);
            $status->bindValue(7, $fichaTecnica->componentes_ft, PDO::PARAM_STR);
            $status->bindValue(8, $fichaTecnica->metodologia_ft, PDO::PARAM_STR);
            $status->bindValue(9, $fichaTecnica->comportamento_ft, PDO::PARAM_STR);
            $status->bindValue(10, $fichaTecnica->observacoes_ft, PDO::PARAM_STR);
            $status->bindValue(11, $fichaTecnica->visibilidade_ft, PDO::PARAM_STR);
            $status->bindValue(12, $fichaTecnica->destaque_ft, PDO::PARAM_STR);
            $status->bindValue(13, $fichaTecnica->status_ft, PDO::PARAM_STR);
            $status->bindValue(14, $fichaTecnica->id_ft, PDO::PARAM_INT);

            $status->execute();

            $this->connection = null;
            return $fichaTecnica;
        } catch (PDOException $exc) {
            $erro = $exc->getCode();
            unset($_SESSION["success"]);
            $_SESSION['error'] = "Erro $erro! A Ficha Técnica não pode ser atualizada! Entre em contato com a equipe de suporte!";
        }
    }

    public function deletaFichaTecnica($fichaTecnica) {

        try {

            $SQLDelete = "delete from tbl_fichastecnicas where id_ft = ?";
            $status = $this->connection->prepare($SQLDelete);

            $status->bindValue(1, $fichaTecnica->id_ft, PDO::PARAM_INT);
            $status->execute();

            $this->connection = null;
        } catch (PDOException $exc) {
            $erro = $exc->getCode();
            unset($_SESSION["success"]);
            $_SESSION['error'] = "Erro $erro! A Ficha Técnica não pode ser excluída! Entre em contato com a equipe de suporte!";
        }
    }

}
