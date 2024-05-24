<?php
require_once "../../connect.php";
require_once "../../auth/session/index.php";
?>
<div class="col-md-8 mt-3 bg-white">
    <div class="row">
        <div class="col-lg-12 mt-3 pb-5 border-bottom">
            <h2>Cadastrar Novo Usuário</h2>
            <form class="row formulario">
                <input type="text" name="acao" hidden='true' value='cadastrar_usuario'>

                <div class="col-md-12">
                    <label>Nome Completo</label>
                    <input type="text" name="nome" class="form-control" maxlength="50" required>
                </div>
                <div class="col-md-12">
                    <label>Login, RG ou CPF:</label>
                    <input type="number" name="username" class="form-control" placeholder="Somente números." required>
                    <small></small>
                </div>
                <div class="col-md-12">
                    <label>Senha</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-12">
                    <label>Confirme a Senha</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <div class="d-grid mt-3">
                    <button class="btn btn-primary btn-block botaoFormulario" onclick="submitThrouthAjax(this)" type="button">Cadastrar</button>
                </div>
            </form>
            <div class="serverResponse"></div>
        </div>

        <div class="col-lg-12 mt-4 ">
            <h2>Usuários</h2>
            <div class="table-responsive">
                <table class="table table-stripped table-hover display" id="tabelaSSP">
                    <thead class="thead-dark">
                        <tr style="text-transform: capitalize;">
                            <th>status</th>
                            <th>Usuário</th>
                            <th>Nome</th>
                            <th>Nível</th>
                            <th>Criação</th>
                            <th>Exclusão</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $('#tabelaSSP').DataTable({
            ajax: 'public/usuarios/ssp/gestao_ssp.php',
            processing: true,
            serverSide: true,
            order: [0, "desc"],
            language: {
                "url": "plugins/dataTables/js/ptbr.json"
            },
        });
    </script>