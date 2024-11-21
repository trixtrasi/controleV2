<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$servername = "localhost";
$user = "root";
$password = "";
$dbname = "controleV2";

//Create connection
$conn = new mysqli($servername, $user, $password, $dbname);

//Check the connection
if ($conn->connect_error) {
    die("Conexão com problemas<br>" . $conn->connect_error);
}