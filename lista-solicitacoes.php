<?php
require_once("cabecalho.php");

$solicitacaoDAO = new SolicitacaoDAO();
$solicitacoes = $solicitacaoDAO->listaSolicitacoes();

$conta_sol = sizeof($solicitacoes, 0);
?>
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-home"></i>  <a href="minhavisao.php">Minha Visão</a>
            </li>
            <li class="active">
                <i class="fa fa-list-alt"></i> Solicitações
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->

<?php
if (isset($_SESSION["success"])) {
    ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <strong> <?= $_SESSION["success"] ?> </strong>
    </div>
    <?php
    unset($_SESSION["success"]);
}

if (isset($_SESSION["error"])) {
    ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <strong> <?= $_SESSION['error'] ?> </strong>
    </div>
    <?php
    unset($_SESSION["error"]);
}
?>

<div class="row">
    <div class="col-lg-12">

<!--        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Filtros
                    <i class="ace-icon fa bigger-125 fa-chevron-down" data-toggle="collapse" data-target="#collFiltros" 
                       id="paineis-status"></i>
                </h3>
            </div>

            <div class="panel panel-default collapse in" id="collFiltros">

            </div>
        </div>-->

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Lista de Solicitações 
                    <span class="badge"><?php echo $conta_sol ?></span>
                </h3>
            </div>

            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
<!--                                <th>Solicitante</th>-->
                                <th>Nome Solicitação</th>
                                <th>Abertura</th>
                                <th>Necessidade</th>
                                <th>Andamento</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($solicitacoes as $sol) :
                                ?>
                                <tr onClick="defineSessao('id_solicitacao', '<?= $sol->id_sol ?>', 'lista-solicitacao.php')">
                                    <td><?= $sol->id_sol ?></td>
<!--                                    <td><?= $sol->idUsuario_sol ?></td>-->
                                    <td><?= $sol->nome_sol ?></td>
                                    <td><?= formataData($sol->dataAbertura_sol) ?></td>
                                    <td><?= formataData($sol->dataNecessidade_sol) ?></td>
                                    <td><?= formataUmaCasaDecimal(calculaPorcentagem($sol->tempoTeste_sol, somaTempo($sol->id_sol))) ?></td>
                                    <td><?= $sol->status_sol ?></td>
                                </tr>
                            <?php
                        endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <nav aria-label="...">
            <ul class="pager">
                <li class="previous"><a href="#"><span aria-hidden="true">&larr;</span> Anterior</a></li>
                <li class="hidden-xs"><a href="#">1</a></li>
                <li class="next"><a href="#">Próxima <span aria-hidden="true">&rarr;</span></a></li>
            </ul>
        </nav>

    </div>
</div>
<!-- /.row -->

<?php include("rodape.php"); ?>
