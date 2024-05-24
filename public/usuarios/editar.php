<?php require_once "../../auth/session/index.php"; ?>
<div class="col-md-8 mt-3 bg-white">
    <div class="row">
        <div class="col-md-6">
            <h2>Trocar a Senha</h2>
            <form class="formulário">
                <div class="col-md-12">
                    <label>Nova Senha</label>
                    <input type="text" name="acao" value='alterar_senha' class="d-none" required>
                    <input type="text" name="id_user" value="<?php echo $id_user; ?>" class="d-none" required>

                    <input type="password" name="new_password" class="form-control">
                </div>
                <div class="col-md-12">
                    <label>Confirme a Senha</label>
                    <input type="password" name="confirm_password" class="form-control">
                </div>
                <div class="col-md-12 mt-3 d-grid">
                    <button class="btn btn-warning btn-block botaoFormulario" onclick="submitThrouthAjax(this)" type="button">Resetar</button>
                </div>
            </form>
            <div class="serverResponse"></div>
        </div>
        <div class="col-md-6">
            <h2>Editar Dados Pessoias</h2>
            <form class="formulario">
                <input type="text" name="acao" value='editar_dados' class="d-none" required>
                <input type="text" name="id_user" value="<?php echo $id_user; ?>" class="d-none" required>
                <div class="row">
                    <div class="col-md-12">
                        <label for="nome_usuario">Usuário:</label>
                        <input id="nome_usuario" class="form-control" type="number" name="nome_usuario" maxlength="50" value="<?php echo $username; ?>">
                    </div>
                    <div class="col-md-12">
                        <label for="nome">Nome:</label>
                        <input id="nome" class="form-control" type="text" name="nome" maxlength="50" value="<?php echo $nome_user; ?>">
                    </div>
                </div>

                <div class="d-grid mt-3">
                    <button class="btn btn-primary btn-block botaoFormulario" onclick="submitThrouthAjax(this)" type="button">Editar</button>
                </div>
            </form>
            <div class="serverResponse"></div>
        </div>
    </div>
</div>