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
$table = 'visitantes';

// Table's primary key
$primaryKey = 'visitantes__id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

/*setting functions*/
function formatterDate($d){
	if ($d != "" or $d != null or $d == '1969-31-12 00:00:00') {
		$timeSpan = strtotime($d);
		return "<span class=\"d-none\">" . $timeSpan . "</span>" . date("d/m/Y - H:m ", $timeSpan);
	} else {
		return null;
	}
}

$columns = array(
	array('db' => '`visitantes`.`visitantes__id`', 'dt' => 0, 'field' => 'visitantes__id', 'formatter' => function ($d, $row) {
		return '<button data-acao="visualizar" data-visitante-id="' . $d . '" data-visita-id="' . $row[4] . '" type="button" class="btn btn-sm btn-link col-12"  onClick="visualizarModal(this)"><img src="' . $row[8] . '" alt="visualizar" width="50" height="50"></button>';
	}),
	array('db' => '`visitantes`.`visitantes__nome`', 'dt' => 1, 'field' => 'visitantes__nome'),
	array('db' => '`visitantes__visitas`.`visitas__veic_marca`', 'dt' => 2, 'field' => 'visitas__veic_marca', 'formatter' => function ($d, $row) {
		return $d . " " . $row[6] . " " . $row[7];
	}),
	array('db' => '`visitantes__visitas`.`visitas__chegou_d_h`', 'dt' => 3, 'field' => 'visitas__chegou_d_h', 'formatter' => function ($d){
		return formatterDate($d);
	}),
	array('db' => '`visitantes__visitas`.`visitas__id`', 'dt' => 4, 'field' => 'visitas__id', 'formatter' => function ($d){
		return '<button data-acao="encerrarVisita" data-id="' . $d . '" type="button" class="btn btn-sm btn-danger col-12"  onClick="return confirmSubmit(this)">Encerrar Visita</button>';
	} ),
	array('db' => '`visitantes__visitas`.`visitas__id`', 'dt' => 5, 'field' => 'visitas__id'),
	array('db' => '`visitantes__visitas`.`visitas__veic_modelo`', 'dt' => 6, 'field' => 'visitas__veic_modelo'),
	array('db' => '`visitantes__visitas`.`visitas__veic_placa`', 'dt' => 7, 'field' => 'visitas__veic_placa'),
	array('db' => '`visitantes__visitas`.`visitas__img_url`', 'dt' => 8, 'field' => 'visitas__img_url')
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

$joinQuery = "FROM `visitantes` 
			LEFT JOIN `visitantes__visitas`
			ON `visitantes`.`visitantes__id` = `visitantes__visitas`.`visitas__visitante`";

$extraWhere = "`visitantes__visitas`.`visitas__status` = 1";
$groupBy = null;
$having = null;

echo json_encode(
	SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having)
);
