    <?php
    include "../../connect.php";
    include "../../auth/session/index.php";
    ?>

    <div class="col-md-8 mt-3 bg-white">
        <?php
        $id_visita = htmlspecialchars($_POST["visita_id"], ENT_QUOTES);
        $id_visitante = htmlspecialchars($_POST["visitante_id"], ENT_QUOTES);

        $query = mysqli_query($conn, "SELECT *
                                    FROM `visitantes` 
                                    LEFT JOIN `visitantes__visitas`
                                    ON `visitantes`.`visitantes__id` = `visitantes__visitas`.`visitas__visitante`
                                    WHERE `visitantes__visitas`.`visitas__id` = $id_visita");
        $visita_visualizar = mysqli_fetch_array($query);

        //visitas anterriores dessa pessoa
        $sqlAnterrior = "SELECT * 
                        FROM `visitantes__visitas`
                        WHERE `visitas__id` != '$id_visita' AND `visitas__visitante` LIKE '$id_visitante' AND `visitas__status` != -1
                        ORDER BY visitas__id DESC
                        LIMIT 10";

        $query_anterrior = mysqli_query($conn, $sqlAnterrior);

        if (mysqli_num_rows($query_anterrior) > 0 and $nivel_user == 5) {
            $visita_anterior = "";
            $i = 0;
            foreach ($query_anterrior as $outrasVisitas) {
                $saida_data = (!empty($outrasVisitas['visitas__saiu_d_h'])) ? date('D d/m/Y - H:m', strtotime($outrasVisitas['visitas__saiu_d_h'])) : "Ainda no local";

                if (!empty($outrasVisitas["visitas__img_url"])) {
                    $img_src = $outrasVisitas["visitas__img_url"];
                } else {
                    if ($visita_visualizar["visitantes__genero"] == "Feminino") {
                        $rand = random_int(1, 15);
                    } else {
                        $rand = random_int(16, 32);
                    }
                    $diretorio = "public/visitas/img/visitantes_genericos";
                    $img_src = $diretorio . DIRECTORY_SEPARATOR . $rand . '.png';
                }

                $visita_anterior .=
                    '<table class="table table-sm table-striped table-hover mb-5">
                        <tbody>
                            <tr>
                                <th rowspan="4" class="col-md-2">
                                    <div class="d-flex justify-content-center" style="height: 6rem;">
                                        <img src="' . $img_src . '" class="img-fluid rounded">
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <td class="col-md-2"><strong>Chegou às:</strong></td>
                                <td>' . date('D d/m/Y - H:m', strtotime($outrasVisitas['visitas__chegou_d_h'])) . '</td>
                            </tr>
                            <tr>
                                <td><strong>Saiu às:</strong></td>
                                <td>' . $saida_data . '</td>
                            </tr>
                            <tr>
                                <td><strong>Motivo:</strong> </td>
                                <td>' . $outrasVisitas['visitas__motivo'] . '</td>
                            </tr>
                            <tr>
                            <td colspan="3"><button data-acao="visualizar" data-visitante-id="' . $id_visitante . '" data-visita-id="' . $outrasVisitas["visitas__id"] . '" type="button" class="btn btn-sm btn-dark col-12"  onClick="visualizarModal(this)">visualizar</button></td>
                            </tr>
                            </tbody>
                        </table>';
            }
        }
        ?>
        <h1><?php echo ucfirst($visita_visualizar["visitantes__nome"]); ?></h1>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <tbody>
                    <tr>
                        <td class="fw-bold">Chegou às:</td>
                        <td><?php echo date("D d/m/Y - H:m", strtotime($visita_visualizar["visitas__chegou_d_h"])); ?></td>
                        <td class="w-25" rowspan="8">
                            <?php
                            if (!empty($visita_visualizar["visitas__img_url"])) {
                                $img_url = str_replace("..", "public", $visita_visualizar["visitas__img_url"]);
                            } else {
                                if ($visita_visualizar["visitantes__genero"] == "Feminino") {
                                    $rand = random_int(1, 15);
                                } else {
                                    $rand = random_int(16, 32);
                                }
                                $diretorio = "public/visitas/img/visitantes_genericos";
                                $img_url = $diretorio . DIRECTORY_SEPARATOR . $rand . '.png';
                            }
                            ?>
                            <img class="img-fluid img-thumbnail" src="<?php echo $img_url; ?>" alt="foto do visitante" style="max: 16em;">
                        </td>
                    </tr>
                    <tr>
                        <td class='fw-bold'>Saiu às:</td>
                        <?php
                        if ($visita_visualizar["visitas__status"] == 0) {
                            echo "
                        <td>" . date("D d/m/Y - H:m", strtotime($visita_visualizar["visitas__saiu_d_h"])) . "</td>";
                        } else {
                            echo "
                        <td><span class='fw-bold'>AINDA NO LOCAL</span></td>";
                        }
                        ?>
                    </tr>
                    <tr>
                        <td colspan="2" class="fw-bold">Veículo</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Marca / Modelo:</td>
                        <td><?php echo $visita_visualizar["visitas__veic_marca"] . " " . $visita_visualizar["visitas__veic_modelo"]; ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Placa:</td>
                        <td><?php echo $visita_visualizar["visitas__veic_placa"]; ?></td>
                    </tr>

                    <tr>
                        <td class="fw-bold">Resp. pelo visitante:</td>
                        <td><?php echo $visita_visualizar["visitas__pm_acompanhante"]; ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Motivo da Visita:</td>
                        <td><?php echo $visita_visualizar["visitas__motivo"]; ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Observações:</td>
                        <td><?php echo $visita_visualizar["visitas__obs"]; ?></td>
                    </tr>
                </tbody>
            </table>

            <h2>Dados Pessoais</h2>
            <table class="table table-striped table-sm">
                <tbody>
                    <tr>
                        <td class="fw-bold">Nome:</td>
                        <td><?php echo ucfirst($visita_visualizar["visitantes__nome"]); ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Documento:</td>
                        <td><?php echo $visita_visualizar["visitantes__tipo_doc"] . ' ' . $visita_visualizar["visitantes__num_doc"]; ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Aniversário:</td>
                        <td><?php echo ($visita_visualizar["visitantes__aniversario"] != "1969-31-12") ? date("d/m/Y", strtotime($visita_visualizar["visitantes__aniversario"])) : "não informado"; ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Endereço:</td>
                        <td><?php echo $visita_visualizar["visitantes__endereco"] ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Sexo:</td>
                        <td><?php echo $visita_visualizar["visitantes__genero"] ?></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Telefone:</td>
                        <td><?php echo $visita_visualizar["visitantes__telefone"]; ?></td>
                    </tr>
                </tbody>
            </table>

            <?php
            echo (!empty($visita_anterior)) ? '<h2 class="mt-5">Outras Visitas:</h2>' . $visita_anterior : "";
            ?>
        </div>