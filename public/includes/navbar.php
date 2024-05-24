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