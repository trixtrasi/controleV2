<?php
require_once "auth/session/index.php";
require_once "connect.php";
?>
 <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Acesso de Visitantes</title>
    <!--FAV ICONS-->
    <link type="image/png" rel="icon" href="http://localhost/controlev2/public/img/png/password.png">
    <!--BOOTSTRAP-->
    <link rel="stylesheet" href="http://localhost/controlev2/plugins/bootstrap-5.0.2-dist/css/bootstrap.css">
    <link rel="stylesheet" href="http://localhost/controlev2/plugins/bootstrap-5.0.2-dist/css/bootstrap-grid.css">
    <!--CSS | COMPLEMENTAR-->
    <link rel="stylesheet" href="http://localhost/controlev2/public/css/complements.css">
    <!--CSS | DATATABLES-->
    <link rel="stylesheet" href="http://localhost/controlev2/plugins/dataTables/css/dataTables.dataTables.min.css">

    <!--BOOTSTRAP-->
    <script src="http://localhost/controlev2/plugins/bootstrap-5.0.2-dist/js/bootstrap.js"></script>
    <!--JQUERY-->
    <script src="http://localhost/controlev2/plugins/jquery/jquery.js"></script>
    <!-- DATATABLES - JS -->
    <script src="http://localhost/controlev2/plugins/dataTables/js/dataTables.min.js"></script>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark text-uppercase fixed-top border-top border-bottom" style="border-top:0px!important;">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <ul class="nav navbar-nav me-auto mb-2 mb-lg-0">
                <!--LINK PARA EXPORTAR EXCEL-->
                <li class="nav-item">
                    <a class="nav-link">
                        <img class="d-inlne-block align-top" height="30" src="public/img/png/1crpm.png" alt="icon da empressa">
                    </a>
                </li>
                <li class="nav-item">
                    <label class="nav-link link-ajax active" data-for="public/home/index">
                        HOME
                    </label>
                </li>
                <li class="nav-item">
                    <label class="nav-link link-ajax" data-for="public/visitas/cadastro">NOVO VISITANTE</label>
                </li>
                <li class="nav-item">
                    <label class="nav-link link-ajax" data-for="public/visitas/encerrado">VISITAS ENCERRADAS</label>
                </li>
                <li class="nav-item">
                    <label class="nav-link link-ajax" data-for="public/visitas/local" id="numeroUsuarios">VISITAS NO LOCAL</label>
                </li>
                <?php
                if ($nivel_user == 5) {
                    echo '<li class="nav-item">
                            <label class="nav-link link-ajax" data-for="public/usuarios/gestao">GESTÃO DE USUÁRIO</label>
                        </li>';
                }
                ?>
            </ul>
            <div class="d-flex">
                <!--NOME DO USUÁRIO LOGADO-->
                <label class="nav-link link-ajax text-white" data-for="public/usuarios/editar"><?php echo $nome_user; ?></label>
                <!--IMAGEM - LINK DE LOGUOT-->
                <a class="navbar-brand" href="auth/logout/">
                    <img class="d-inlne-block align-top" width="30" height="30" src="public/img/png/shutdown.png" alt="imagem de logout">
                </a>
            </div>
        </div>
    </div>
</nav>

<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
    <div class="container-fluid bg-light">
        <div class="justify-content-center d-flex min-vh-100 mt-5 row" id="mainContent">
            <?php
             include "public/home/index.php"; 
            ?>
        </div>
    </div>
</div>
    <footer class="text-center text-white bg-dark">
        <!-- Grid container -->
        <div class="container p-4">
            <div class="row d-flex justify-content-around">
                <div class="col-lg-4 col-md-12 text-uppercase">
                    <p>Lorem ipsum dolor sit</p>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="text-center p-1 bc-1000">
            © 2024 ツ
        </div>
        <!-- Copyright -->
    </footer>
    <!-- CONTROLE DO NAVBAR -->
    <script src="http://localhost/controlev2/public/js/navbar.js"></script>
    <!-- AJAX -->
    <script src="http://localhost/controlev2/public/js/ajax.js"></script>
    <!--JQUERY MASKS-->
    <script src="http://localhost/controlev2/public/js/jquery.mask.js"></script>
    <!-- CONTROLE DE INATIVADE DO USUÁRIO -->
    <script src="http://localhost/controlev2/public/js/inatividade.js"></script>
    <!-- CONFIRMAR A AÇÃO DO USUÁRIO -->
    <script src="http://localhost/controlev2/public/js/confirmSubmit.js"></script>
</body>
</html>
