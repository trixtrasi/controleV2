<?php

include "../../connect.php";
include "../includes/head.php";
include "../auth/session/index.php";
//declaramos uma variavel para monstarmos a tabela
$visitantes  = "";
$visitantes .= "  <table border='1' >";
$visitantes .= "     <thead>";
$visitantes .= "        <tr>";
$visitantes .= "          <th>id</th>";
$visitantes .= "          <th>nome</th>";
$visitantes .= "          <th>sexo</th>";
$visitantes .= "          <th>data nascimento</th>";
$visitantes .= "          <th>rg</th>";
$visitantes .= "          <th>cpf</th>";
$visitantes .= "          <th>telefone</th>";
$visitantes .= "          <th>endereço</th>";
$visitantes .= "          <th>chegou</th>";
$visitantes .= "          <th>saiu</th>";
$visitantes .= "          <th>motivo</th>";
$visitantes .= "          <th>Responsável</th>";
$visitantes .= "          <th>veículo marca/modelo</th>";
$visitantes .= "          <th>veículo placa</th>";
$visitantes .= "          <th>observações</th>";
$visitantes .= "        </tr>";
$visitantes .= "     </thead>";
$visitantes .= "     <tbody>";

$docs = mysqli_query($conn, "SELECT *
                            FROM `visitantes` 
                            LEFT JOIN `visitas`
                            ON `visitantes`.`id` = `visitas`.`visitante`
                            LEFT JOIN `visitas__veiculos`
                            ON `visitas`.`id` = `visitas__veiculos`.`visitantes`
                            WHERE `visitas`.`status` IN ('0','1')
                            ORDER BY `visitas`.`id` DESC");

// Descobrimos o total de registros encontrados
$numRegistros = mysqli_num_rows($docs);
// Se houver pelo menos um registro, exibe-o
if ($numRegistros != 0) {
    // Exibe os produtos e seus respectivos preços
    while ($doc = mysqli_fetch_array($docs)) {
        $visitantes .= "      <tr>";
        $visitantes .= "          <td>" . $doc['id'] . "</td>";
        $visitantes .= "          <td>" . $doc['nome'] . "</td>";
        $visitantes .= "          <td>" . $doc['genero'] . "</td>";
        $visitantes .= "          <td>" . $doc['aniversario'] . "</td>";
        $visitantes .= "          <td>" . $doc['rg'] . "</td>";
        $visitantes .= "          <td>" . $doc['cpf'] . "</td>";
        $visitantes .= "          <td>" . $doc['telefone'] . "</td>";
        $visitantes .= "          <td>" . $doc['endereco'] . "</td>";
        $visitantes .= "          <td>" . $doc['chegou_d_h'] . "</td>";
        $visitantes .= "          <td>" . $doc['saiu_d_h'] . "</td>";
        $visitantes .= "          <td>" . $doc['motivo'] . "</td>";
        $visitantes .= "          <td>" . $doc['pm_acompanhante'] . "</td>";
        $visitantes .= "          <td>" . $doc['marca'] . " / " . $doc['modelo'] . "</td>";
        $visitantes .= "          <td>" . $doc['placa'] . "</td>";
        $visitantes .= "          <td>" . $doc['obs'] . "</td>";
        $visitantes .= "      </tr>";
    }

    // Se não houver registros
}
$visitantes .= "  </table>";

// Definimos o nome do arquivo que será exportado  
$arquivo = date("d/m/y") . "_" . "relatorio_visitantes.xls";
// Configurações header para forçar o download
header('Content-Encoding: utf-16LE');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $arquivo . '"');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Envia o conteúdo do arquivo  
echo "\xEF\xBB\xBF"; // UTF-8 BOM  
echo mb_strtoupper($visitantes);
exit;
?>
</tbody>
</table>

<?php
include_once "includes/footer.php";
?>
</body>

</html>