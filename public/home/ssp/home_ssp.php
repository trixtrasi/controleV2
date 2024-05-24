<?php
include "../../../auth/session/index.php";
include "../../../connect.php";
////////////////////////////////

/*
* DataTables example server-side processing script.
*
* Please note that this script is intentionally extremely simply to show how
* server-side processing can be implemented, and probably shouldn't be used as
* the basis for a large complex system. It is suitable for simple use cases as
* for learning.
*
* See http://datatables.net/usage/server-side for full details on the server-
* side processing requirements of DataTables.
*
* @license MIT - http://datatables.net/license_mit
*/

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* Easy set variables
*/

// DB table to use
$table = 'eventos';

// Table's primary key
$primaryKey = 'eventos__id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

/*setting functions*/
function formatterDate($d)
{
	if ($d != "" or $d != null or $d == '1969-31-12 00:00:00') {
		$timeSpan = strtotime($d);
		return "<span class=\"d-none\">" . $timeSpan . "</span>" . date("d/m/Y - H:m ", $timeSpan);
	} else {
		return null;
	}
}

function formatterDatePeriod($dataIni, $dataFim)
{
	$inicio = date("d/m/y", strtotime($dataIni));
	$fim = date("d/m/y", strtotime($dataFim));
	$periodoEvento = ($fim != "31/12/69") ? $inicio . " a " . $fim : $inicio;
	return '<span class="d-none">' . $dataIni . "</span>" .  $periodoEvento;
}

$today = date('Y-m-d');

$columns = array(
	array('db' => '`eventos`.`eventos__data_ini`', 'dt' => 0, 'field' => 'eventos__data_ini', 'formatter' => function ($d, $row) {
		return formatterDatePeriod($d, $row[4]);
	}),
	array('db' => '`eventos`.`eventos__texto`', 'dt' => 1, 'field' => 'eventos__texto'),
	array('db' => '`users`.`users__nome`', 'dt' => 2, 'field' => 'users__nome'),
	array('db' => '`eventos`.`eventos__id`', 'dt' => 3, 'field' => 'eventos__id', 'formatter' => function ($d) {
		return '
		<button type="button" class="btn btn-sm btn-danger" data-acao="remover_evento" data-id="' . $d . '" onClick="return confirmSubmit(this)">Excluir</button>';
	}),
	array('db' => '`eventos`.`eventos__data_fim`', 'dt' => 4, 'field' => 'eventos__data_fim')
);

// SQL server connection information
$sql_details = array(
	'user' => $user,
	'pass' => $password,
	'db' => $dbname,
	'host' => $servername
	// ,'charset' => 'utf8' // Depending on your PHP and MySQL config, you may need this
);

require('ssp.customized.class.php');

$joinQuery = "FROM `eventos` 
			LEFT JOIN `users`
			ON `eventos`.`eventos__create_by` = `users`.`users__id`";

$extraWhere = "('$today' BETWEEN `eventos__data_ini` AND `eventos__data_fim` AND `eventos__status` = 1)
                                            OR `eventos__data_ini` = '$today'  AND `eventos__status` = 1";
$groupBy = null;
$having = null;

echo json_encode(
	SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
);
