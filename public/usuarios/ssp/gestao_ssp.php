<?php
include "../../../auth/session/index.php";
include "../../../connect.php";

////////////////////////////////
function formatterDate($d)
{
    if ($d != "" or $d != null or $d == '1969-31-12 00:00:00') {
        return date("H:m d/m/y", strtotime($d));
    } else {
        return null;
    }
}

// DB table to use
$table = 'users';

// Table's primary key
$primaryKey = 'users__id';

// SQL server connection information for datatables
$sql_details = array(
    'user' => $user,
    'pass' => $password,
    'db'   => $dbname,
    'host' => $servername
    // ,'charset' => 'utf8' // Depending on your PHP and MySQL config, you may need this
);

$columns =
    array(
        array(
            'db' => 'users__status',   'dt' => 0,
            'formatter' => function ($d) {
                return ($d == 0) ? "<strong class=\"text-danger\">excluído</strong>" : "ativo";
            }

        ),
        array('db' => 'users__username',   'dt' => 1),
        array('db' => 'users__nome',       'dt' => 2),
        array(
            'db' => 'users__nivel',      'dt' => 3,
            'formatter' => function ($d) {
                $privilegio = ($d == 5) ? "administrador" : "usuário";
                return $privilegio;
            }
        ),
        array(
            'db' => 'users__create_at',  'dt' => 4,
            'formatter' => function ($d) {
                return formatterDate($d);
            }
        ),
        array(
            'db' => 'users__remove_at',  'dt' => 5,
            'formatter' => function ($d) {
                return formatterDate($d);
            }
        ),
        array(
            'db' => 'users__id',    'dt' => 6,
            'formatter' => function ($d, $row) use ($id_user) {
                //usuário excluído
                if ($row[0] == 0) {
                    return '
<button type="button" class="btn btn-sm btn-info w-100" data-acao="reativar_usuario" data-id="' . $d . '"  onClick="return confirmSubmit(this)">Reativar Usuário</button>
<button type="button" class="btn btn-sm btn-outline-danger w-100" data-acao= "expurgar_usuario" data-id="' . $d . '"  onClick="return confirmSubmit(this)">Expurgar Usuário. Sem Retorno.</button>';
                }
                //próprio usuário 
                else if ($id_user == $d) {
                    return 'você não pode alterar seu usuário por aqui!';
                }
                //usuário com nível baixo, usuário
                else if ($row[3] == 1) {
                    return ' 
<div class="btn-group btn-group-sm justify-content-between w-100">
    <button type="button" class="btn btn-warning" data-acao="reseta_senha_usuario" data-id="' . $d . '"  onClick="return confirmSubmit(this)">Redefinir Senha</button>
    <button type="button" class="btn btn-danger" data-acao="remover_usuario" data-id="' . $d . '" onClick="return confirmSubmit(this)">Excluir Usuário</button>
    <button type="button" class="btn btn-success" data-acao="altera_privilegio_usuario" data-id="' . $d . '"  onClick="return confirmSubmit(this)">Adicionar Privilégio</button>
</div>';
                }
                //usuário com nível alto, administrador
                else if ($row[3] == 5) {
                    return ' 
<div class="btn-group btn-group-sm justify-content-between w-100">
    <button type="button" class="btn btn-warning" data-acao="reseta_senha_usuario" data-id="' . $d . '"  onClick="return confirmSubmit(this)">Redefinir Senha</button>
    <button type="button" class="btn btn-danger" data-acao="remover_usuario" data-id="' . $d . '" onClick="return confirmSubmit(this)">Excluir Usuário</button>
    <button type="button" class="btn btn-secondary" data-acao="altera_privilegio_usuario" data-id="' . $d . '"  onClick="return confirmSubmit(this)">Remover Privilégio</button>
</div>';
                }
            }
        )
    );

require('ssp.class.php');

//não seleciono os usuários expurgados. status igual a -1.
$whereAll = "users__status >= 0";

echo json_encode(
    //SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null, $whereAll)
);
