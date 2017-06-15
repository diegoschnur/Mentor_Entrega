<?php

if( !isset($_SESSION['id_us']) ){
    $_SESSION['error'] = "Usuário não logado no sistema.";
    header("Location: index.php");
    die();
}

