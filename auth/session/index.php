<?php
// Inicia a seção
session_start();
//data local
date_default_timezone_set('America/Sao_Paulo');

// Checa se o usuário está logado, caso contrário redireciona
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: auth/login/");
    exit;
}else{
    $id_user = $_SESSION["id"];
    $username = $_SESSION["username"];
    $nome_user = $_SESSION["nome"];
    $nivel_user = $_SESSION["nivel"];
}
