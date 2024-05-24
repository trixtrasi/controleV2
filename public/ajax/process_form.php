<?php
require_once  "../../auth/session/index.php";
require_once  "../../connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /*-*\ GESTÃO DE USUÁRIOS \*-*/
    if ($_POST["acao"] == "cadastrar_usuario") {
        // Define variables and initialize with empty values
        $new_username = $new_password = $new_confirm_password = $new_nome = "";
        $new_username_err = $new_password_err = $new_confirm_password_err = $new_nome_err = "";

        // valida usuario
        if (empty(trim($_POST["username"]))) {
            $new_username_err = "<strong class=\"text-danger\">Preencha o usuário!</strong><br>";
        } elseif (!preg_match('/[0-9]/', trim($_POST["username"]))) {
            $new_username_err = "<strong class=\"text-danger\">Nome de usuário só pode conter números!</strong><br>";
        } else {
            // Prepare a select statement
            $sql = "SELECT users__id FROM users WHERE users__username = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                // Set parameters
                $param_username = trim($_POST["username"]);

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    /* store result */
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        $new_username_err = "<strong class=\"text-danger\">Usuário já cadastrado!</strong><br>";
                    } else {
                        $new_username = trim($_POST["username"]);
                    }
                } else {
                    echo "<strong class=\"text-danger\">Algo deu errado contate o suporte!</strong><br>";
                }
                // Close statement
                mysqli_stmt_close($stmt);
            }
        }

        // Validate password
        if (empty(trim($_POST["password"]))) {
            $new_password_err = "<strong class=\"text-danger\">Informe uma senha!</strong><br>";
        } else {
            $new_password = trim($_POST["password"]);
        }

        // Validate confirm password
        if (empty(trim($_POST["confirm_password"]))) {
            $new_confirm_password_err = "<strong class=\"text-danger\">Confirme a senha!</strong><br>";
        } else {
            $new_confirm_password = trim($_POST["confirm_password"]);
            if (empty($new_password_err) && ($new_password != $new_confirm_password)) {
                $new_confirm_password_err = "<strong class=\"text-danger\">Senha não bate!</strong><br>";
            }
        }

        // Validate nome
        if (empty(trim($_POST["nome"]))) {
            $new_nome_err = "<strong class=\"text-danger\">Informe um nome de usuário!</strong><br>";
        } else {
            $new_nome = trim($_POST["nome"]);
        }

        // Check input errors before inserting in database
        if (empty($new_username_err) && empty($new_password_err) && empty($new_confirm_password_err) && empty($new_nome_err)) {
            // Prepara a declaração de inserção
            $sql = "INSERT INTO users (users__username, users__password, users__nome) VALUES (?, ?, ?)";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_nome);

                // Set parameters
                $param_username = $new_username;
                $param_password = password_hash($new_password, PASSWORD_DEFAULT);
                $param_nome = $new_nome;
                // Define a resposta como erro com as mensagens de erro concatenadas
                $message = "";
                if (!empty($new_username_err)) {
                    $message .= " " . $new_username_err;
                }
                if (!empty($new_password_err)) {
                    $message .= " " . $new_password_err;
                }
                if (!empty($new_confirm_password_err)) {
                    $message .= " " . $new_confirm_password_err;
                }
                if (!empty($new_nome_err)) {
                    $message .= " " . $new_nome_err;
                }

                // Attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    // Define a resposta como sucesso
                    $response = array("status" => "success", "message" => "<strong class=\"text-success\">Usuário cadastrado com sucesso!</strong><br>");
                } else if (empty($message)) {
                    // Define a resposta como erro
                    $error_message = mysqli_stmt_error($stmt);
                    $response = array("status" => "error", "message" => $error_message);
                } else {
                    // Define a resposta como erro
                    $response = array("status" => "error", "message" => $message);
                }

                // Close statement
                mysqli_stmt_close($stmt);
            } else {
                // Erro na preparação da declaração SQL
                $response = array("status" => "error", "message" => "Erro na preparação da declaração SQL");
            }
        } else {
            // Define a resposta como erro com as mensagens de erro concatenadas
            $message = "";
            if (!empty($new_username_err)) {
                $message .= " " . $new_username_err;
            }
            if (!empty($new_password_err)) {
                $message .= " " . $new_password_err;
            }
            if (!empty($new_confirm_password_err)) {
                $message .= " " . $new_confirm_password_err;
            }
            if (!empty($new_nome_err)) {
                $message .= " " . $new_nome_err;
            }
            // Define a resposta como erro com as mensagens de erro
            $response = array(
                "status" => "error",
                "message" => $message
            );
        }

        // Envia a resposta como JSON
        echo json_encode($response);
    } else if ($_POST["acao"] == "reseta_senha_usuario") {
        // Verifica se o ID do usuário foi enviado
        if (isset($_POST["id"])) {

            //parametros
            $nova_senha = password_hash('123456', PASSWORD_DEFAULT);
            $id_user = $_POST["id"];

            $sql = "UPDATE `users` SET `users__password` = ? WHERE `users__id` = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                //bind in the name of emperror 
                mysqli_stmt_bind_param($stmt, "ss", $nova_senha, $id_user);

                if (mysqli_stmt_execute($stmt)) {
                    //sucesso
                    $response = array("status" => "success", "message" => "Senha alterada com sucesso!");
                } else {
                    //erro
                    $error_message = mysqli_stmt_error($stmt);
                    $response = array("status" => "error", "message" => $error_message);
                }
                // Fecha a declaração
                mysqli_stmt_close($stmt);
            } else {
                // Erro na preparação da declaração SQL
                $response = array("status" => "error", "message" => "Erro na preparação da declaração SQL");
            }
        } else {
            // Se o ID do usuário não foi enviado, retorna uma resposta de erro
            $response = array("status" => "error", "message" => "ID do usuário não recebido.");
        }
        echo json_encode($response);
    } else if ($_POST["acao"] == "altera_privilegio_usuario") {
        // Verifica se o ID do usuário foi enviado
        if (isset($_POST["id"])) {
            $id_user_privilegio = $_POST["id"];

            $sql = "UPDATE `users` SET `users__nivel` = CASE 
										WHEN users__nivel = 5 THEN 1
                                        WHEN users__nivel = 1 THEN 5
									END
                    WHERE `users__id` = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                //for the glory of mankind
                mysqli_stmt_bind_param($stmt, "s", $id_user_privilegio);

                if (mysqli_stmt_execute($stmt)) {
                    // Define a resposta como sucesso
                    $response = array("status" => "success", "message" => "Privilégio de usuário alterado com sucesso!");
                } else {
                    $error_message = mysqli_stmt_error($stmt);
                    $response = array("status" => "error", "message" => $error_message);
                }
                // Fecha a declaração
                mysqli_stmt_close($stmt);
            } else {
                // Erro na preparação da declaração SQL
                $response = array("status" => "error", "message" => "Erro na preparação da declaração SQL");
            }
        } else {
            // Se o ID do usuário não foi enviado, retorna uma resposta de erro
            $response = array("status" => "error", "message" => "ID do usuário não recebido.");
        }
        echo json_encode($response);
    } else if ($_POST["acao"] == "remover_usuario") {
        // Verifica se o ID do usuário foi enviado
        if (isset($_POST["id"])) {
            // parametros
            $senhaExcluido = -4815162342;
            $stsExcluido = 0;
            $remove_at = date("Y-m-d H:i:s");
            $id_user = $_POST["id"];

            $sql = "UPDATE `users` SET `users__password` = ?, `users__status` = ?, `users__remove_at` = ? WHERE `users__id` = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                //for the glory of mankind
                mysqli_stmt_bind_param($stmt, "ssss", $senhaExcluido, $stsExcluido, $remove_at, $id_user);

                if (mysqli_stmt_execute($stmt)) {
                    // Define a resposta como sucesso
                    $response = array("status" => "success", "message" => "Usuário removido com sucesso!");
                } else {
                    $error_message = mysqli_stmt_error($stmt);
                    $response = array("status" => "error", "message" => $error_message);
                }
                // Fecha a declaração
                mysqli_stmt_close($stmt);
            } else {
                // Erro na preparação da declaração SQL
                $response = array("status" => "error", "message" => "Erro na preparação da declaração SQL");
            }
        } else {
            // Se o ID do usuário não foi enviado, retorna uma resposta de erro
            $response = array("status" => "error", "message" => "ID do usuário não recebido.");
        }
        echo json_encode($response);
    } else if ($_POST["acao"] == "expurgar_usuario") {
        // Verifica se o ID do usuário foi enviado
        if (isset($_POST["id"])) {
            $novo_status = -1;
            $remove_at = date("Y-m-d H:i:s");
            $id_user_expurgar = $_POST["id"];

            $sql = "UPDATE `users` SET `users__status` = ?, `users__remove_at` = ? WHERE `users__id` = ?";

            // Verifica se a consulta foi bem-sucedida
            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Prepare params
                mysqli_stmt_bind_param($stmt, "sss", $novo_status, $remove_at, $id_user_expurgar);

                // Verifica se a consulta foi bem-sucedida
                if (mysqli_stmt_execute($stmt)) {
                    // Define a resposta como sucesso
                    $response = array("status" => "success", "message" => "Usuário Expurgado com sucesso! Esse usuário não retornará.");
                } else {
                    // Define a resposta como erro com a mensagem de erro do MySQL
                    $error_message = mysqli_stmt_error($stmt);
                    $response = array("status" => "error", "message" => "Erro: " . $error_message);
                }
                // Fecha a declaração
                mysqli_stmt_close($stmt);
            } else {
                // Erro na preparação da declaração SQL
                $response = array("status" => "error", "message" => "Erro na preparação da declaração SQL");
            }
        } else {
            // Se o ID do usuário não foi enviado, retorna uma resposta de erro
            $response = array("status" => "error", "message" => "ID do usuário não recebido.");
        }

        echo json_encode($response);
    } else if ($_POST["acao"] == "reativar_usuario") {
        // Verifica se o ID do usuário foi enviado
        if (isset($_POST["id"])) {
            $nova_senha = password_hash('123456', PASSWORD_DEFAULT);
            $novo_status = 1;
            $data_remocao = date("Y-m-d H:i:s");
            $id_user_reativar = $_POST["id"];

            $sql = "UPDATE `users` SET `users__password` = ?, `users__status` = ?, `users__remove_at` = ? WHERE `users__id` = ?";

            // Verifica se a consulta foi bem-sucedida
            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Prepare params
                mysqli_stmt_bind_param($stmt, "ssss", $nova_senha, $novo_status, $data_remocao, $id_user_reativar);

                // Verifica se a consulta foi bem-sucedida
                if (mysqli_stmt_execute($stmt)) {
                    // Define a resposta como sucesso
                    $response = array("status" => "success", "message" => "Usuário Reativado com sucesso!");
                } else {
                    // Define a resposta como erro com a mensagem de erro do MySQL
                    $error_message = mysqli_stmt_error($stmt);
                    $response = array("status" => "error", "message" => "Erro: " . $error_message);
                }
                // Fecha a declaração
                mysqli_stmt_close($stmt);
            } else {
                // Erro na preparação da declaração SQL
                $response = array("status" => "error", "message" => "Erro na preparação da declaração SQL");
            }
        } else {
            // Se o ID do usuário não foi enviado, retorna uma resposta de erro
            $response = array("status" => "error", "message" => "ID do usuário não recebido.");
        }
        echo json_encode($response);
    }
    /*-*\ EDIÇÃO DE USUÁRIOS \*-*/ else if ($_POST["acao"] == "alterar_senha") {
        // Define variables and initialize with empty values
        $new_password = $confirm_password = "";
        $new_password_err = $confirm_password_err = "";

        // Validate new password
        if (empty(trim($_POST["new_password"]))) {
            $new_password_err = "Informe uma nova senha.";
        } else {
            $new_password = trim($_POST["new_password"]);
        }

        // Validate confirm password
        if (empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "Confirme a nova senha.";
        } else {
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($new_password_err) && ($new_password != $confirm_password)) {
                $confirm_password_err = "Senhas precisam ser iguais.";
            }
        }

        // Check input errors before updating the database
        if (empty($new_password_err) && empty($confirm_password_err)) {
            $sql = "UPDATE `users` SET `users__password` = ? WHERE `users__id` = ?";

            // Verifica se a consulta foi bem-sucedida
            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Prepare params
                mysqli_stmt_bind_param($stmt, "ss", $new_password_hashed, $id_user);

                //bind parameters
                $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

                // Verifica se a consulta foi bem-sucedida
                if (mysqli_stmt_execute($stmt)) {
                    // Define a resposta como sucesso
                    $response = array("status" => "success", "message" => "Alterado dados do usuário com sucesso!");
                } else {
                    // Define a resposta como erro com a mensagem de erro do MySQL
                    $error_message = mysqli_stmt_error($stmt);
                    $response = array("status" => "error", "message" => "Erro: " . $error_message);
                }
                // Fecha a declaração
                mysqli_stmt_close($stmt);
            } else {
                // Erro na preparação da declaração SQL
                $response = array("status" => "error", "message" => "Erro na preparação da declaração SQL");
            }
        } else {
            // Define a resposta como erro com a mensagem de erro
            $response = array("status" => "error", "message" => "Erro: " . $new_password_err . " " . $confirm_password_err);
        }

        // Envia a resposta como JSON
        echo json_encode($response);
    } else if ($_POST["acao"] == "editar_dados") {
        // Verifica se o ID do usuário foi enviado
        $new_username = htmlspecialchars($_POST["nome_usuario"], ENT_QUOTES, "UTF-8");
        $new_nome = htmlspecialchars($_POST["nome"], ENT_QUOTES, "UTF-8");

        $sql = "UPDATE `users` SET `users__username` = ?, `users__nome` = ?  WHERE `users__id` = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "sss", $new_username, $new_nome, $id_user);

            // Verifica se a consulta foi bem-sucedida
            if (mysqli_stmt_execute($stmt)) {
                // Define a resposta como sucesso
                //atualizo a session com o nome de usuário e nome 
                $_SESSION["username"] = $new_username;
                $_SESSION["nome"] = $new_nome;
                // Define a resposta como sucesso
                $response = array("status" => "success", "message" => "Alterado dados do usuário com sucesso!", "action" => "refresh");
            } else {
                // Define a resposta como erro com a mensagem de erro do MySQL
                $error_message = mysqli_stmt_error($stmt);
                $response = array("status" => "error", "message" => "Erro: " . $error_message);
            }
            // Fecha a declaração
            mysqli_stmt_close($stmt);
        } else {
            // Erro na preparação da declaração SQL
            $response = array("status" => "error", "message" => "Erro na preparação da declaração SQL");
        }
        // Envia a resposta como JSON

        echo json_encode($response);
    }
    /*-*\ VISITANTES \*-*/ else if ($_POST["acao"] == "salvaFotos") {
        //se for enviado alguma imagem é feito o upload e update da tabela
        if ($_FILES["foto_visitante"]["error"] == 0) {
            $uploadOk = 1;
            $error_message = "";
            $visitantes__id = $_POST["visitantes__id"];

            // Diretório de destino para o upload da imagem
            $target_dir = "../visitas/img/visitantes/" . $visitantes__id . "/";
            $target_dirAfterUpload = "public/visitas/img/visitantes/" . $visitantes__id . "/";

            // Obtendo a extensão do arquivo original
            $imageFileType = strtolower(pathinfo($_FILES["foto_visitante"]["name"], PATHINFO_EXTENSION));

            // Alterando o nome do arquivo para a data em segundos
            $dateUni = time();
            $target_file = $target_dir . $dateUni . '.' . $imageFileType;
            $target_file_afterUpload = $target_dirAfterUpload . $dateUni . '.' . $imageFileType;


            // Verifica se o arquivo é uma imagem real
            $check = getimagesize($_FILES["foto_visitante"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
                $error_message .= "Por favor, escolha uma foto real.";
            }

            // Verifica o tamanho do arquivo
            if ($_FILES["foto_visitante"]["size"] > 6250000) {
                $uploadOk = 0;
                $error_message .= "Foto muito grande!";
            }
            // Verifica os formatos de arquivo permitidos
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $uploadOk = 0;
                $error_message .= "Foto em formato não permitido!";
            }

            // Move o arquivo para o diretório de destino se tudo estiver correto
            if ($uploadOk == 1) {
                if (is_dir($target_dir) == false) {
                    mkdir($target_dir, 0777, true);
                }
                if (move_uploaded_file($_FILES["foto_visitante"]["tmp_name"], $target_file)) {
                    // Define a resposta como sucesso
                    $response = array("status" => "success", "message" => "Foto salva!", "url" => $target_file_afterUpload);
                } else {
                    // Problemas ao mover o arquivo
                    $response = array("status" => "error", "message" => "Problemas ao enviar a foto!");
                }
            } else {
                // Erros detectados durante a verificação do arquivo
                $response = array("status" => "error", "message" => $error_message);
            }
        } else {
            // Erro ao enviar o arquivo de imagem
            $response = array("status" => "error", "message" => "Erro ao enviar o arquivo de imagem.");
        }

        // Envia a resposta como JSON
        echo json_encode($response);
    } else if ($_POST["acao"] == "visitante_cadastrar") {
        //salvar foto. PRA DEPOIS. 
        //na ordem: 
        //1 crio o visitante ao abrir a página como visitante temporário
        //2 salvo a foto
        //3 update no visitante com os dados informados
        //4 crio a visita
        //****************************************************************** */
        //dados do visitante
        $visitantes__id = ($_POST["visitantes__id"]);
        $visitantes__nome = htmlspecialchars($_POST["visitante_nome"], ENT_QUOTES, "UTF-8");
        $visitantes__genero = $_POST["genero"];
        $visitantes__tipo_doc = $_POST["tipoDocumento"];
        $visitantes__num_doc = htmlspecialchars($_POST["numeroDocumento"], ENT_QUOTES, "UTF-8");
        $visitantes__aniversario = $_POST["aniversario"];
        $visitantes__telefone = htmlspecialchars($_POST["telefone"], ENT_QUOTES, "UTF-8");
        $visitantes__endereco = htmlspecialchars($_POST["endereco"], ENT_QUOTES, "UTF-8");
        //dados da visita
        $pm_acompanhate = htmlspecialchars($_POST["pm_acompanhate"], ENT_QUOTES, "UTF-8");
        $visitante_motivo = htmlspecialchars($_POST["visitante_motivo"], ENT_QUOTES, "UTF-8");
        $veiculo_marca = htmlspecialchars($_POST["veiculo_marca"], ENT_QUOTES, "UTF-8");
        $veiculo_modelo = htmlspecialchars($_POST["veiculo_modelo"], ENT_QUOTES, "UTF-8");
        $veiculo_placa = htmlspecialchars($_POST["veiculo_placa"], ENT_QUOTES, "UTF-8");
        $obs_adiconais = htmlspecialchars($_POST["obs_adiconais"], ENT_QUOTES, "UTF-8");
        $visitas__img_url = htmlspecialchars($_POST["url_foto"], ENT_QUOTES, "UTF-8");

        //sql
        $update_visitante = "UPDATE `visitantes` SET `visitantes__status`= 1,`visitantes__nome`='$visitantes__nome',`visitantes__aniversario`='$visitantes__aniversario',`visitantes__tipo_doc`='$visitantes__tipo_doc',`visitantes__num_doc`='$visitantes__num_doc',`visitantes__genero`='$visitantes__genero',`visitantes__endereco`='$visitantes__endereco',`visitantes__telefone`='$visitantes__telefone' WHERE `visitantes__id` = '$visitantes__id'";

        mysqli_query($conn, $update_visitante);

        $sql_visita = "INSERT INTO `visitantes__visitas`(`visitas__visitante`, `visitas__create_by`,  `visitas__status`, `visitas__pm_acompanhante`, `visitas__motivo`,`visitas__obs`, `visitas__veic_marca`,`visitas__veic_modelo`,`visitas__veic_placa`,`visitas__img_url`) VALUES ('$visitantes__id','$id_user',1, '$pm_acompanhate','$visitante_motivo','$obs_adiconais', '$veiculo_marca','$veiculo_modelo','$veiculo_placa','$visitas__img_url')";

        $query_visita = mysqli_query($conn, $sql_visita);
        $last_visita_id = $conn->insert_id;

        // Verifica se a consulta foi bem-sucedida
        if ($query_visita) {
            // Define a resposta como sucesso
            $response = array("status" => "success", "message" => "Visita Cadastrada!", "action" => "changeHeader");
        } else {
            // Define a resposta como erro com a mensagem de erro do MySQL
            $response = array("status" => "error", "message" => "Erro: " . $conn->error);
        }
        // Envia a resposta como JSON
        echo json_encode($response);
    } else if ($_POST["acao"] == "encerrarVisita") {
        // Verifica se o ID do usuário foi enviado
        if (isset($_POST["id"])) {
            $dataAgora = date("Y-m-d H:i:s");
            $visitas_staus = 0;
            $id_user = $_POST["id"];

            $sql = "UPDATE `visitantes__visitas` SET `visitas__saiu_d_h` = ?, `visitas__status` = ? WHERE `visitas__id` = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "sss", $dataAgora, $visitas_staus, $id_user);

                // Verifica se a consulta foi bem-sucedida
                if (mysqli_stmt_execute($stmt)) {
                    // Define a resposta como sucesso
                    $response = array("status" => "success", "message" => "Visita encerrada!");
                } else {
                    // Define a resposta como erro com a mensagem de erro do MySQL
                    $error_message = mysqli_stmt_error($stmt);
                    $response = array("status" => "error", "message" => "Erro: " . $error_message);
                }
            } else {
                // Erro na preparação da declaração SQL
                $response = array("status" => "error", "message" => "Erro na preparação da declaração SQL");
            }
            // Fecha a declaração
            mysqli_stmt_close($stmt);
        } else {
            // Se o ID do usuário não foi enviado, retorna uma resposta de erro
            $response = array("status" => "error", "message" => "ID do usuário não recebido.");
        }
        echo json_encode($response);
    } else if ($_POST["acao"] == "pesquisaVisitante") {
        $tipoDocumento = $_POST["tipoDocumento"];
        $numeroDocumento = htmlspecialchars($_POST["numeroDocumento"], ENT_QUOTES, "UTF-8");
        // Inicializa um array para armazenar os visitantes
        $visitantes = array();

        // Consulta para verificar se o visitante já existe
        $sql = "SELECT * FROM `visitantes` 
                LEFT JOIN `visitantes__visitas`
                ON `visitantes__visitas`.`visitas__visitante` = `visitantes`.`visitantes__id`
                WHERE `visitantes__tipo_doc` LIKE ? AND `visitantes__num_doc` = ? 
                ORDER BY `visitantes__visitas`.`visitas__id` DESC
                LIMIT 1";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind parameters 
            mysqli_stmt_bind_param($stmt, "ss", $tipoDocumento, $numeroDocumento);

            // Verifica se a consulta foi bem-sucedida
            if (mysqli_stmt_execute($stmt)) {
                // Obtem o resultado da consulta
                $result = mysqli_stmt_get_result($stmt);

                // Verifica se foi encontrado algum visitante com o documento informado
                if ($row = mysqli_fetch_assoc($result)) {
                    $visitantes[] = $row;
                    $visitante_status = $visitantes[0]["visitas__status"];
                    //verifico se o visitante já está no local
                    if ($visitante_status == 1) {
                        $response = array("status" => "error", "message" => "Visitante no local!");
                    } else {
                        $response = array("status" => "success", "visitantes" => $visitantes);
                    }
                    //nenhum visitante encontrado
                } else {
                    $response = array("status" => "error",  "visitantes_doc" => $numeroDocumento,  "message" => "Visitante não encontrado! Cadatrar um novo?");
                }
                // Libera o resultado
                mysqli_free_result($result);
            } else {
                $response = array("status" => "error", "message" => "Erro ao executar a consulta!");
            }

            // Fecha a declaração
            mysqli_stmt_close($stmt);
        } else {
            // Erro na preparação da declaração SQL
            $response = array("status" => "error", "message" => "Erro na preparação da declaração SQL");
        }
        // Retorna a resposta como JSON
        echo json_encode($response);
    } else if ($_POST["acao"] == "excluirVisita"){
        // Verifica se o ID do usuário foi enviado
        if (isset($_POST["id"])) {
            $visitas_staus = -1;
            $id_user = $_POST["id"];

            $sql = "UPDATE `visitantes__visitas` SET `visitas__status` = ? WHERE `visitas__id` = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "ss", $visitas_staus, $id_user);

                // Verifica se a consulta foi bem-sucedida
                if (mysqli_stmt_execute($stmt)) {
                    // Define a resposta como sucesso
                    $response = array("status" => "success", "message" => "Visita excluída!");
                } else {
                    // Define a resposta como erro com a mensagem de erro do MySQL
                    $error_message = mysqli_stmt_error($stmt);
                    $response = array("status" => "error", "message" => "Erro: " . $error_message);
                }
            } else {
                // Erro na preparação da declaração SQL
                $response = array("status" => "error", "message" => "Erro na preparação da declaração SQL");
            }
            // Fecha a declaração
            mysqli_stmt_close($stmt);
        } else {
            // Se o ID do usuário não foi enviado, retorna uma resposta de erro
            $response = array("status" => "error", "message" => "ID do usuário não recebido.");
        }
        echo json_encode($response);
    }
    /*-*\ EVENTOS \*-*/ else if ($_POST["acao"] == "evento_cadastro") {
        // Set parameters
        $eventos_data_ini = $_POST["eventos__data_ini"];
        $eventos_data_fim = ($_POST["eventos__data_fim"] == '') ? null : $_POST["eventos__data_fim"];
        $eventos_texto = htmlentities($_POST["eventos__texto"], ENT_QUOTES, "UTF-8");
        $usuario = $_SESSION["id"];

        $sql = "INSERT INTO `eventos` (`eventos__data_ini`, `eventos__data_fim`, `eventos__texto`, `eventos__create_by`) VALUES (?,?,?,?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ssss", $eventos_data_ini, $eventos_data_fim, $eventos_texto, $usuario);

            // Verifica se a consulta foi bem-sucedida
            if (mysqli_stmt_execute($stmt)) {
                // Define a resposta como sucesso
                $response = array("status" => "success", "message" => "<strong class=\"text-success\">Evento cadastrado com sucesso!</strong>");
            } else {
                // Define a resposta como erro com a mensagem de erro do MySQL
                $error_message = mysqli_stmt_error($stmt);
                $response = array("status" => "error", "message" => "Erro: " . $error_message);
            }
            // Fecha a declaração
            mysqli_stmt_close($stmt);
        } else {
            // Erro na preparação da declaração SQL
            $response = array("status" => "error", "message" => "Erro na preparação da declaração SQL");
        }

        echo json_encode($response);
    } else if ($_POST["acao"] == "remover_evento") {
        // Verifica se o ID do usuário foi enviado
        if (isset($_POST["id"])) {
            //set parameters
            $evento_status = 0;
            $id_user = $_SESSION["id"];
            $id_evento = $_POST["id"];

            $sql = "UPDATE `eventos` SET `eventos__status` = ?, `eventos__exclude_by` = ?  WHERE `eventos__id` = ?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "sss", $evento_status, $id_user, $id_evento);

                // Verifica se a consulta foi bem-sucedida
                if (mysqli_stmt_execute($stmt)) {
                    // Define a resposta como sucesso
                    $response = array("status" => "success", "message" => "Removido com sucesso!");
                } else {
                    // Define a resposta como erro com a mensagem de erro do MySQL
                    $error_message = mysqli_stmt_error($stmt);
                    $response = array("status" => "error", "message" => "Erro: " . $error_message);
                }
                // Fecha a declaração
                mysqli_stmt_close($stmt);
            } else {
                // Erro na preparação da declaração SQL
                $response = array("status" => "error", "message" => "Erro na preparação da declaração SQL");
            }
            // Envia a resposta como JSON
            echo json_encode($response);
        } else {
            // Se o ID não foi enviado, retorna uma resposta de erro
            $response = array("status" => "error", "message" => "ID não recebido.");
            echo json_encode($response);
        }
    }
}
